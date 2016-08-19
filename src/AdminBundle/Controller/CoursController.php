<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CoursController extends Controller
{
    public function indexAction($id)
    {
        $rep=$this->getDoctrine()->getRepository("AdminBundle:Emploi");

        $aEmploi=$rep->find($id);

        return $this->render("AdminBundle:Cours:index.html.twig",[
            "aEmploi"=>$aEmploi
        ]);
    }

    public function addAction(Request $request,$id)
    {
        $form=$this->createForm(CoursType::class);

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Emploi");

        $aEmploi=$rep->find($id);

        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $p=$form->getData();

            $p->setEmploi($aEmploi);

            $em=$this->getDoctrine()->getManager();

            $em->persist($p);
            $em->flush();

            $this->addFlash("notice","le cours a ete ajouté avec success !");

            return $this->redirectToRoute("ad_cours",["id"=>$aEmploi->getId()]);

        }

        return $this->render("AdminBundle:Cours:add.html.twig",[
            "form"=>$form->createView(),
            "aEmploi"=>$aEmploi
        ]);
    }

    public function editAction($id,Request $request)
    {
        $rep=$this->getDoctrine()->getRepository("AdminBundle:Cours");

        $c=$rep->find($id);

        $form=$this->createForm(CoursType::class,$c);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $c=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($c);
            $em->flush();

            $this->addFlash("notice"," le cours a ete modifie avec success !");

            $referer =$request->headers->get('referer');

            return new RedirectResponse($referer);
        }
        return $this->render("AdminBundle:Cours:edit.html.twig",[
            "form"=>$form->createView(),
            "idclasse"=>$id
        ]);
    }
}
