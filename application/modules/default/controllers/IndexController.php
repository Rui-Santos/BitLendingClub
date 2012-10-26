<?php

/**
 * 
 */
class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        //$this->view->headScript()->appendFile('/js/jquery.countdown.min.js', $type = 'text/javascript', $attrs = array());
    }

    public function indexAction()
    {
        $this->view->headMeta()->appendName('keywords', 'Cisco Trainings, Juniper Trainings,NetAPP, ITIL, Checkpoint, VMWare, Instructors, CCNA, CCIE, CCSI, NetApp Trainers, Trainers, Professional Instructors');
        $this->view->headMeta()->appendName('description', 'IT-Instructor.com delivers professional and advanced technology trainers on Cisco, NetApp, IBM, HP, Juniper,ITIL, VMware, Checkpoint and professional skills. Trainers and Instructors provisioning and delivery');
        $this->view->headTitle('IT-Instructor.com | Cisco Trainings, Juniper Trainings,NetAPP, ITIL, Checkpoint, VMWare, Instructors, CCNA, CCIE, CCSI');  
    }  
    
}