<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
         $this->_helper->authentication->checkAuthentication(false);
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
       
    }


}

