<?php

namespace AdminBundle\Controller;

use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {
        $source= new Entity("AdminBundle:User");

        $grid=$this->get("grid");

        $grid->setSource($source);



        $myRowAction2=new RowAction('desactiver','ad_users_active',true);
        $myRowAction2->manipulateRender(function($action,$row){
            if($row->getField('enabled')){
                $action->setTitle("Desactiver");
            }else{
                $action->setTitle("Activer");
            }

            if(in_array("ROLE_SUPER_ADMIN",$row->getField('roles'))){

                $action->setEnabled("false");
                $action->setTitle("");
            }

            return $action;
        });


        $grid->addRowAction($myRowAction2);

        $grid->setLimits([5,10,15,20,50,100]);

        $grid->setVisibleColumns(['id','username','email','enabled','lastLogin']);

        return $grid->getGridResponse('AdminBundle:Users:index.html.twig');
    }

    public function activeAction($id)
    {
        $rep=$this->getDoctrine()->getRepository("AdminBundle:User");

        $user=$rep->find($id);
        if($user){

            $user->setEnabled($user->isEnabled()?false:true);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notice',"Vous venez de modifier l'etat de ".$user->getUsername());
        }
        return $this->redirectToRoute("ad_users");
    }
}
