<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\EcoleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConfigurationController extends Controller
{
    public function indexAction(Request $request)
    {
        $rep=$this->getDoctrine()->getRepository("AdminBundle:Ecole");
        $ec=$rep->find(1);



        return $this->render("AdminBundle:Configuration:index.html.twig",[
            "ecole"=>$ec
        ]);
    }

    public function editAction(Request $request)
    {
        $rep=$this->getDoctrine()->getRepository("AdminBundle:Ecole");
        $ec=$rep->find(1);

        $form=$this->createForm(EcoleType::class,$ec);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $ec=$form->getData();

            $file=$ec->getLogo();

            dump($ec->getLogo());

           /* $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            $ec->setLogo($fileName);


            $em = $this->getDoctrine()->getManager();

            $em->persist($ec);
            $em->flush();

            $this->addFlash("notice", $ec->getNom() . " a ete modifie avec success !");
           */
        }
        return $this->render("AdminBundle:Configuration:edit.html.twig",[
            "form"=>$form->createView()
        ]);
    }

}
