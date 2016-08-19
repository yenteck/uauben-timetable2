<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\ArticleType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InfosController extends Controller
{
    public function indexAction(Request $request)
    {
        $userid=$this->getUser()->getId();
        $QB=$this->getDoctrine()->getManager()->createQueryBuilder();

        $source= new Entity("AdminBundle:Article");

        $grid=$this->get("grid");

        $grid->setSource($source);


        $myRowAction=new RowAction('modifier','ad_infos_edit',false,'_self',[
            "editable"=>true
        ]);
        $myRowAction->manipulateRender(function($action,$row){
            //$action->setEnabled(false);
            $action->addAttribute("edit",$row->getField("id"));
            return $action;
        });

        $myRowAction2=new RowAction('supprimer','ad_infos_delete',true);


        $grid->addRowAction($myRowAction);
        $grid->addRowAction($myRowAction2);

        $grid->setLimits([5,10,15,20,50,100]);

        $grid->hideFilters();

        return $grid->getGridResponse('AdminBundle:Infos:index.html.twig');
    }

    public function addAction(Request $request)
    {
        $form=$this->createForm(ArticleType::class);


        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $art=$form->getData();
            $art->setUser($this->getUser());

            $em=$this->getDoctrine()->getManager();

            $em->persist($art);
            $em->flush();

            $this->addFlash("notice","L'article ".$art->getId()." a ete ajouté avec success !");

            return $this->redirectToRoute("ad_infos");

        }

        return $this->render("AdminBundle:Infos:add.html.twig",[
            "form"=>$form->createView(),
        ]);
    }




    public function editAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Article");

        $a=$rep->find($id);

        $form=$this->createForm(ArticleType::class,$a);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $l=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($a);
            $em->flush();

            $this->addFlash("notice","l'article a ete modifie avec success !");

            return $this->redirectToRoute("ad_infos");

        }
        return $this->render("AdminBundle:Infos:edit.html.twig",[
            "form"=>$form->createView(),
            "idarticle"=>$id
        ]);
    }

    public function deleteAction($id){
        if($id){
            $repP=$this->getDoctrine()->getRepository("AdminBundle:Article");
            $em=$this->getDoctrine()->getManager();

            if($article=$repP->find($id)){
                $em->remove($article);

                $this->addFlash("notice","l'article supprime avec success");


            }
        }

        return $this->redirectToRoute("ad_infos");
    }
}
