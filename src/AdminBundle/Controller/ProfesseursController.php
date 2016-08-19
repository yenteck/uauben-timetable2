<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\ProfesseursType;
use APY\DataGridBundle\Grid\Export\PHPExcelPDFExport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ProfesseursController extends Controller
{
    public function indexAction(Request $request)
    {
        // Creates a simple grid based on your entity (ORM)
        $source = new Entity("AdminBundle:Professeurs");

        // Get a Grid instance
        $grid = $this->get('grid');

        // Attach the source to the grid
        $grid->setSource($source);

        $grid->setLimits(array(5, 10, 15));

        // Set the default page
        $grid->setDefaultPage(1);

        $yourMassAction = new MassAction('Action 1', 'UAUBEN-TIMETABLE2\AppBundle\Controller\DefaultController::mass');
        //$grid->addMassAction($yourMassAction);

        //$grid->addMassAction(new DeleteMassAction());

        //

        $MyColumn = new BlankColumn(array('id' => '<a>ddd</a>', 'title'=>'My Column', 'size' => '54'));
        //$grid->addColumn($MyColumn, 6);



        // Add a typed column with a rendering callback

        $myRowAction=new RowAction('modifier','edit_route',false,'_self',[
            "editable"=>true
        ]);
        $myRowAction->manipulateRender(function($action,$row){
            //$action->setEnabled(false);
            $action->addAttribute("edit",$row->getField("id"));
            return $action;
        });

        $myRowAction2=new RowAction('supprimer','ad_professeurs_delete',true);

        $grid->addRowAction($myRowAction);
        $grid->addRowAction($myRowAction2);

        // ccustom action column
        $actionCol=new ActionsColumn("info_column","info");


       // $grid->addColumn($actionCol,2);



        //custom row
        $sRowAction = new RowAction('Show', 'edit_route',true);
        $sRowAction->setColumn('info_column');

        //$grid->addRowAction($sRowAction);

        $grid->addExport(new CSVExport('CSV EXPORT','lesprofs'));
        $grid->addExport(new ExcelExport('EXCELL EXPORT','lesprofs'));
        $grid->addExport(new JSONExport('JSON EXPORT','lesprofs'));



        //$grid->setVisibleColumns(["nom","prenom"]);
        $grid->setNoResultMessage("PAS DE RESULTAT ");
        // Return the response of the grid to the template
        return $grid->getGridResponse('AdminBundle:Professeurs:index.html.twig');
        //return $this->render("AdminBundle:Professeurs:index.html.twig");
    }

    public function deleteAction($id){
        if($id){
            $repP=$this->getDoctrine()->getRepository("AdminBundle:Professeurs");
            $em=$this->getDoctrine()->getManager();

            if($prof=$repP->find($id)){
                $em->remove($prof);

                $this->addFlash("notice","le professeur ".$prof->getNom()." ".$prof->getPrenom()." supprime avec success");


            }
        }

        return $this->redirectToRoute("ad_professeurs");
    }

    public function editAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Professeurs");

        $p=$rep->find($id);

        $form=$this->createForm(ProfesseursType::class,$p);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $p=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($p);
            $em->flush();

            $this->addFlash("notice",$p->getNom()." a ete modifie avec success !");

            return $this->redirectToRoute("ad_professeurs");

        }
        return $this->render("AdminBundle:Professeurs:edit.html.twig",[
            "form"=>$form->createView(),
            "idprof"=>$id
        ]);
    }

    public function addAction(Request $request)
    {
        $form=$this->createForm(ProfesseursType::class);



        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $p=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($p);
            $em->flush();

            $this->addFlash("notice",$p->getNom()." a ete ajouté avec success !");

            return $this->redirectToRoute("ad_professeurs");

        }

        return $this->render("AdminBundle:Professeurs:add.html.twig",[
            "form"=>$form->createView(),
        ]);
    }
}
