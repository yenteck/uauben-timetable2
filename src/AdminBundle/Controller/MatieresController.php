<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\MatiereType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MatieresController extends Controller
{
    public function indexAction()
    {
        $source= new Entity("AdminBundle:Matiere");

        $grid=$this->get("grid");

        $grid->setSource($source);


        $myRowAction=new RowAction('modifier','ad_matieres_edit',false,'_self',[
            "editable"=>true
        ]);
        $myRowAction->manipulateRender(function($action,$row){
            //$action->setEnabled(false);
            $action->addAttribute("edit",$row->getField("id"));
            return $action;
        });

        $myRowAction2=new RowAction('supprimer','ad_matieres_delete',true);


        $grid->addRowAction($myRowAction);
        $grid->addRowAction($myRowAction2);

        $grid->setLimits([5,10,15,20,50,100]);

        return $grid->getGridResponse('AdminBundle:Matieres:index.html.twig');
    }

    public function addAction(Request $request)
    {
        $form=$this->createForm(MatiereType::class);



        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $m=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($m);
            $em->flush();

            $this->addFlash("notice",$m->getCode()." a ete ajouté avec success !");

            return $this->redirectToRoute("ad_matieres");

        }

        return $this->render("AdminBundle:Matieres:add.html.twig",[
            "form"=>$form->createView(),
        ]);
    }

    public function editAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Matiere");

        $m=$rep->find($id);

        $form=$this->createForm(MatiereType::class,$m);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $m=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($m);
            $em->flush();

            $this->addFlash("notice",$m->getCode()." a ete modifie avec success !");

            return $this->redirectToRoute("ad_classes");

        }
        return $this->render("AdminBundle:Matieres:edit.html.twig",[
            "form"=>$form->createView(),
            "idmatiere"=>$id
        ]);
    }

    public function deleteAction($id){
        if($id){
            $rep=$this->getDoctrine()->getRepository("AdminBundle:Matiere");
            $em=$this->getDoctrine()->getManager();

            if($matiere=$rep->find($id)){
                $em->remove($matiere);

                $this->addFlash("notice","la matiere ".$matiere->getCode()." a étée supprime avec success");


            }
        }

        return $this->redirectToRoute("ad_matieres");
    }
}
