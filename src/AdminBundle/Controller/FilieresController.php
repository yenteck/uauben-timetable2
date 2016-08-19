<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\FiliereType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FilieresController extends Controller
{
    public function indexAction(Request $request)
    {

        $source= new Entity("AdminBundle:Filiere");

        $grid=$this->get("grid");

        $grid->setSource($source);


        $myRowAction=new RowAction('modifier','edit_route',false,'_self',[
            "editable"=>true
        ]);
        $myRowAction->manipulateRender(function($action,$row){
            //$action->setEnabled(false);
            $action->addAttribute("edit",$row->getField("id"));
            return $action;
        });

        $myRowAction2=new RowAction('supprimer','ad_filieres_delete',true);


        $grid->addRowAction($myRowAction);
        $grid->addRowAction($myRowAction2);

        $grid->setLimits([5,10,15,20,50,100]);

        return $grid->getGridResponse('AdminBundle:Filieres:index.html.twig');
    }

    public function addAction(Request $request)
    {
        $form=$this->createForm(FiliereType::class);



        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $p=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($p);
            $em->flush();

            $this->addFlash("notice",$p->getCode()." a ete ajouté avec success !");

            return $this->redirectToRoute("ad_filieres");

        }

        return $this->render("AdminBundle:Filieres:add.html.twig",[
            "form"=>$form->createView(),
        ]);
    }

    public function editAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Filiere");

        $f=$rep->find($id);

        $form=$this->createForm(FiliereType::class,$f);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $p=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($p);
            $em->flush();

            $this->addFlash("notice",$p->getCode()." a ete modifie avec success !");

            return $this->redirectToRoute("ad_filieres");

        }
        return $this->render("AdminBundle:Filieres:edit.html.twig",[
            "form"=>$form->createView(),
            "idfiliere"=>$id
        ]);
    }

    public function deleteAction($id){
        if($id){
            $rep=$this->getDoctrine()->getRepository("AdminBundle:Filiere");
            $em=$this->getDoctrine()->getManager();

            if($fil=$rep->find($id)){
                $em->remove($fil);

                $this->addFlash("notice","la filiere ".$fil->getCode()." a étée supprime avec success");


            }
        }

        return $this->redirectToRoute("ad_filieres");
    }

}
