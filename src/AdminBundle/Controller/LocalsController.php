<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\LocalType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LocalsController extends Controller
{
    public function indexAction(Request $request)
    {
        $source= new Entity("AdminBundle:Local");

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

        $grid->hideFilters();

        return $grid->getGridResponse('AdminBundle:Locals:index.html.twig');
    }

    public function addAction(Request $request)
    {
        $form=$this->createForm(LocalType::class);



        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $l=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($l);
            $em->flush();

            $this->addFlash("notice",$l->getNom()." a ete ajouté avec success !");

            return $this->redirectToRoute("ad_locals");

        }

        return $this->render("AdminBundle:Locals:add.html.twig",[
            "form"=>$form->createView(),
        ]);
    }


    public function editAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Local");

        $l=$rep->find($id);

        $form=$this->createForm(LocalType::class,$l);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $l=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($l);
            $em->flush();

            $this->addFlash("notice",$l->getNom()." a ete modifie avec success !");

            return $this->redirectToRoute("ad_locals");

        }
        return $this->render("AdminBundle:Locals:edit.html.twig",[
            "form"=>$form->createView(),
            "idlocal"=>$id
        ]);
    }
}
