<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Emploi;
use AdminBundle\Form\EmploiType;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmploisController extends Controller
{
    public function indexAction()
    {

        $source= new Entity("AdminBundle:Emploi");

        $grid=$this->get("grid");
        $grid->setDefaultOrder('id','DESC');
        $grid->setSource($source);


        $myRowAction=new RowAction('modif |','ad_emplois_edit',false,'_self',[
        ]);
        $myRowAction->manipulateRender(function($action,$row){
            if($row->getField("expired")==false){

                $action->setTitle("re-utiliser |");
                $action->addAttribute("reuse ",$row->getField("id"));
            }else{
                $action->addAttribute("edit ",$row->getField("id"));
            }

            return $action;
        });

        $myRowAction2=new RowAction('supp |','ad_emplois_delete',true);
        $myRowAction3=new RowAction('cours','ad_cours');



        $grid->addRowAction($myRowAction);
        $grid->addRowAction($myRowAction2);
        $grid->addRowAction($myRowAction3);

        $grid->setLimits([5,10,15,20,50,100]);
        $grid->setDefaultOrder("id", "DESC");

        return $grid->getGridResponse('AdminBundle:Emplois:index.html.twig');
    }

    public function reuseAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Emploi");

        $e=$rep->find($id);

        $form=$this->createForm(EmploiType::class,$e);

        //creation de nouveau emploi


        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $emp=$form->getData();

            // copie des données
            $n_emp=clone $emp;

            ## get the timetable title
            $m_debut=$emp->getDatedebut();
            $m_fin=$emp->getDatefin();

            $m_debut=$m_debut->format("d M");
            $m_fin=$m_fin->format("d M");

            $n_emp->setTitre("Emploi de temps du ".$m_debut." au ".$m_fin);
            $n_emp->setExpired(true);
            ## get the timetable title

            //end copie

            $em=$this->getDoctrine()->getManager();

            $em->persist($n_emp);
            $em->flush();

            $this->addFlash("notice"," L'emploi a ete reutilise avec success !");

            return $this->redirectToRoute("ad_emplois");

        }
        return $this->render("AdminBundle:Emplois:reuse.html.twig",[
            "form"=>$form->createView(),
            "idemploi"=>$id
        ]);
    }

    public function addAction(Request $request)
    {
        $form=$this->createForm(EmploiType::class);



        if($request->isMethod("POST")){
            $form->handleRequest($request);

            $emp=$form->getData();

            ## get the timetable title
            $m_debut=$emp->getDatedebut();
            $m_fin=$emp->getDatefin();

            $m_debut=$m_debut->format("d M");
            $m_fin=$m_fin->format("d M");

            $emp->setTitre("Emploi de temps du ".$m_debut." au ".$m_fin);
            ## get the timetable title




            $em=$this->getDoctrine()->getManager();

            $em->persist($emp);
            $em->flush();

            $this->addFlash("notice",$emp->getTitre()." a ete ajouté avec success !");

            return $this->redirectToRoute("ad_emplois");

        }

        return $this->render("AdminBundle:Emplois:add.html.twig",[
            "form"=>$form->createView(),
        ]);
    }

    public function editAction($id,Request $request){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Emploi");

        $e=$rep->find($id);

        $form=$this->createForm(EmploiType::class,$e);



        if($request->isMethod("POST")){

            $form->handleRequest($request);

            $e=$form->getData();

            $em=$this->getDoctrine()->getManager();

            $em->persist($e);
            $em->flush();

            $this->addFlash("notice"," L'emploi a ete modifie avec success !");

            return $this->redirectToRoute("ad_emplois");

        }
        return $this->render("AdminBundle:Emplois:edit.html.twig",[
            "form"=>$form->createView(),
            "idemploi"=>$id
        ]);
    }

    public function deleteAction($id){
        if($id){
            $rep=$this->getDoctrine()->getRepository("AdminBundle:Emploi");
            $em=$this->getDoctrine()->getManager();

            if($emp=$rep->find($id)){
                $em->remove($emp);

                $em->flush();
                $this->addFlash("notice","L'emploi  a étée supprime avec success");


            }
        }

        return $this->redirectToRoute("ad_emplois");
    }

    public function displayAction($id){

        $rep=$this->getDoctrine()->getRepository("AdminBundle:Emploi");

        $e=$rep->find($id);

        $tabEmploi=[];
        $cours=$e->getCours();

        foreach($cours as $c){


            $hdeb=$c->getHeuredebut()->format("H\h:i");
            $hfin=$c->getHeurefin()->format("H\h:i");
            $tabEmploi[$c->getJour()->format("D")][$hdeb."-".$hfin]=[
                "id"=>$c->getId(),
                "hd"=>$hdeb,
                "hf"=>$hfin,
                "note"=>$c->getNote(),
                "mat"=>$c->getMatiere()->getCode(),
                "salle"=>$c->getSalle()->getCode(),
                "prof"=>$c->getProfesseur()->getNomcourt(),
            ];


        }


        return $this->render("AdminBundle:Emplois:display.html.twig",[
            "emploi"=>$e,
            "tabEmploi"=>$tabEmploi
        ]);
    }
}
