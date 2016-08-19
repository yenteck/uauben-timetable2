<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {

        $rep=$this->getDoctrine()->getRepository('AdminBundle:Classe');

        $classes=$rep->findAll();

        $QB=$this->getDoctrine()->getManager()->createQueryBuilder();

        $QB
            ->select("a")
            ->from("AdminBundle:Article","a")
            ->orderBy("a.id","DESC")
            ->setMaxResults(3)
            ->setFirstResult(0);

        $infos=$QB->getQuery()->getResult();



        return $this->render("AppBundle:Home:home.html.twig",[
            "classes"=>$classes,
            "articles"=>$infos
        ]);
    }
}
