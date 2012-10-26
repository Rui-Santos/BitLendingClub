<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->authentication->checkAuthentication(Model_User::ADMIN_ROLE);
    }

    public function indexAction()
    {
    }


}

