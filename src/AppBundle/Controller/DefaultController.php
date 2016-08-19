<?php

namespace AppBundle\Controller;


use APY\DataGridBundle\Grid\Action\DeleteMassAction;
use APY\DataGridBundle\Grid\Action\MassAction;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Column\DateColumn;
use APY\DataGridBundle\Grid\Export\CSVExport;
use APY\DataGridBundle\Grid\Export\ExcelExport;
use APY\DataGridBundle\Grid\Export\JSONExport;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Professeurs");

        $data=$rep->findAll();


        $datagrid=$this->get("datatheke.datagrid")->createHttpDataGrid("AdminBundle:Professeurs");

        $view=$datagrid->handleRequest($request);



        return $this->render('AppBundle:Default:index.html.twig',[
            "datagrid"=>$view
        ]);
    }

    public function apygridAction(Request $request){

        // Creates a simple grid based on your entity (ORM)
       	$source = new Entity("AdminBundle:Professeurs");

       	// Get a Grid instance
       	$grid = $this->get('grid');

       	// Attach the source to the grid
       	$grid->setSource($source);

        $grid->setLimits(array(2, 10, 15));

        // Set the default page
        $grid->setDefaultPage(1);

        $yourMassAction = new MassAction('Action 1', 'UAUBEN-TIMETABLE2\AppBundle\Controller\DefaultController::mass');
        //$grid->addMassAction($yourMassAction);

        //$grid->addMassAction(new DeleteMassAction());

        //

        $MyColumn = new BlankColumn(array('id' => '<a>ddd</a>', 'title'=>'My Column', 'size' => '54'));
        //$grid->addColumn($MyColumn, 6);



        // Add a typed column with a rendering callback
        $MyColumn2 = new DateColumn(array('id' => 'Another Column', 'sortable' => true, 'true' => false, 'source' => false));
        $MyColumn2->manipulateRenderCell(function($value, $row, $router) {
            return $router->generate('edit_route', array('param' => $row->getField('id')));}
        );
        //$grid->addColumn($MyColumn2,6);

        $myRowAction=new RowAction('modifier','edit_route',true);

        $grid->addRowAction($myRowAction);

        // ccustom action column
        $actionCol=new ActionsColumn("info_column","info");


        $grid->addColumn($actionCol,2);



        //custom row
        $sRowAction = new RowAction('Show', 'edit_route',true);
        $sRowAction->setColumn('info_column');

        $grid->addRowAction($sRowAction);

        $grid->addExport(new CSVExport('CSV EXPORT','lesprofs'));
        $grid->addExport(new ExcelExport('EXCELL EXPORT','lesprofs'));
        $grid->addExport(new JSONExport('JSON EXPORT','lesprofs'));


        $grid->setVisibleColumns(["nom","prenom"]);
        $grid->setNoResultMessage("PAS DE RESULTAT ");
       	// Return the response of the grid to the template
       	return $grid->getGridResponse('AppBundle::grid.html.twig');

    }

    public static  function massAction(){
        dump("MAASS ACTION EFFECTUE");
        return new Response("thi a mass actio");
    }
}
