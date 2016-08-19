<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\SalleType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SallesController extends Controller
{
    public function indexAction(Request $request)
    {
        $source= new Entity("AdminBundle:Salle");

        $grid=$this->get("grid");

        $grid->setSource($source);


        $myRowAction=new RowAction('modifier','ad_salles_edit',false,'_self',[
            "editable"=>true
        ]);
        $myRowAction->manipulateRender(function($action,$row){
            //$action->setEnabled(false);
            $action->addAttribute("edit",$row->getField("id"));
            return $action;
        });

        $myRowAction2=new RowAction('supprimer','ad_salles_delete',true);


        $grid->addRowAction($myRowAction);
        $grid->addRowAction($myRowAction2);

        $grid->setLimits([5,10,15,20,50,100]);

        return $grid->getGridResponse('AdminBundle:Salles:index.html.twig');
    }

    public function addAction(Request $request)
    {
        $form=$this->createForm(SalleType::class);



        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $s=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($s);
            $em->flush();

            $this->addFlash("notice",$s->getCode()." a ete ajouté avec success !");

            return $this->redirectToRoute("ad_salles");

        }

        return $this->render("AdminBundle:Salles:add.html.twig",[
            "form"=>$form->createView(),
        ]);
    }

    public function editAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Salle");

        $s=$rep->find($id);

        $form=$this->createForm(SalleType::class,$s);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $p=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($p);
            $em->flush();

            $this->addFlash("notice",$p->getCode()." a ete modifie avec success !");

            return $this->redirectToRoute("ad_salles");

        }
        return $this->render("AdminBundle:Salles:edit.html.twig",[
            "form"=>$form->createView(),
            "idfiliere"=>$id
        ]);
    }

    public function deleteAction($id){
        if($id){
            $rep=$this->getDoctrine()->getRepository("AdminBundle:Salle");
            $em=$this->getDoctrine()->getManager();

            if($salle=$rep->find($id)){
                $em->remove($salle);

                $this->addFlash("notice","la salle ".$salle->getCode()." a étée supprime avec success");


            }
        }

        return $this->redirectToRoute("ad_salles");
    }
}
