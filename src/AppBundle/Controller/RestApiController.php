<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RestApiController extends Controller
{
    public function indexAction()
    {
        return $this->render('');
    }

    public function infosAction(Request $request)
    {
        $page=$request->query->get('page',1);

        $maxResult=10;

        $QB=$this->getDoctrine()->getManager()->createQueryBuilder();

        $QB
            ->select('i')
            ->from("AdminBundle:Article",'i')
            ->orderBy('i.id','DESC')
            ->setMaxResults($maxResult)
            ->setFirstResult(0);

        $res=$QB->getQuery()->getResult();

        $infos=[];
        foreach($res as $r){
            $infos[]=[
                "id"=>$r->getId(),
                "titre"=>$r->getTitre(),
                "contenu"=>$r->getContenu(),
                "datepublication"=>$r->getDatecreation()
            ];
        }

        $arr=[
            'infos'=>$infos,
            'statut'=>'ok'
        ];

        return new JsonResponse($arr);
    }

    public function classesAction(Request $request)
    {
        $page=$request->query->get('page',1);

        $maxResult=10;

        $QB=$this->getDoctrine()->getManager()->createQueryBuilder();

        $QB
            ->select('c')
            ->from("AdminBundle:Classe",'c')
            ->orderBy('c.code','ASC')
            ->setMaxResults($maxResult)
            ->setFirstResult(0);

        $res=$QB->getQuery()->getResult();

        $classes=[];
        foreach($res as $r){
            $classes[]=[
                "id"=>$r->getId(),
                "code"=>$r->getCode(),
                "filiere"=>[
                    "code"=>$r->getFiliere()->getCode(),
                    "libelle"=>$r->getFiliere()->getLibelle()
                ]

            ];
        }

        $arr=[
            'infos'=>$classes,
            'statut'=>'ok'
        ];

        return new JsonResponse($arr);
    }
}
