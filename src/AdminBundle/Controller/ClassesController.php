<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\ClasseType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClassesController extends Controller
{
    public function indexAction(Request $request)
    {
        $source= new Entity("AdminBundle:Classe");

        $grid=$this->get("grid");

        $grid->setSource($source);


        $myRowAction=new RowAction('modifier','ad_classes_edit',false,'_self',[
            "editable"=>true
        ]);
        $myRowAction->manipulateRender(function($action,$row){
            //$action->setEnabled(false);
            $action->addAttribute("edit",$row->getField("id"));
            return $action;
        });

        $myRowAction2=new RowAction('supprimer','ad_classes_delete',true);


        $grid->addRowAction($myRowAction);
        $grid->addRowAction($myRowAction2);

        $grid->setLimits([5,10,15,20,50,100]);

        return $grid->getGridResponse('AdminBundle:Classes:index.html.twig');
    }

    public function addAction(Request $request)
    {
        $form=$this->createForm(ClasseType::class);



        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $c=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($c);
            $em->flush();

            $this->addFlash("notice",$c->getCode()." a ete ajouté avec success !");

            return $this->redirectToRoute("ad_classes");

        }

        return $this->render("AdminBundle:Classes:add.html.twig",[
            "form"=>$form->createView(),
        ]);
    }

    public function editAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Classe");

        $c=$rep->find($id);

        $form=$this->createForm(ClasseType::class,$c);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $c=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($c);
            $em->flush();

            $this->addFlash("notice",$c->getCode()." a ete modifie avec success !");

            return $this->redirectToRoute("ad_classes");

        }
        return $this->render("AdminBundle:Classes:edit.html.twig",[
            "form"=>$form->createView(),
            "idclasse"=>$id
        ]);
    }

    public function deleteAction($id){
        if($id){
            $rep=$this->getDoctrine()->getRepository("AdminBundle:Classe");
            $em=$this->getDoctrine()->getManager();

            if($cl=$rep->find($id)){
                $em->remove($cl);

                $this->addFlash("notice","la classe ".$cl->getCode()." a étée supprime avec success");


            }
        }

        return $this->redirectToRoute("ad_classes");
    }
}
