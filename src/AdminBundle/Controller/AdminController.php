<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Professeurs");

        $NB_PROFS=count($rep->findAll());

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Filiere");

        $NB_FILIERES=count($rep->findAll());

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Matiere");

        $NB_MATIERES=count($rep->findAll());

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Classe");

        $NB_CLASSES=count($rep->findAll());


        return $this->render("AdminBundle:Default:index.html.twig",[
            "NB_PROFS"=>$NB_PROFS,
            "NB_FIL"=>$NB_FILIERES
        ]);
    }
}
