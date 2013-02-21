<?php

/**
 *
 * @author Yasen Yankov
 *  
 */
class Default_UserController extends Zend_Controller_Action
{

    /**
     *
     * @var type 
     */
    protected $_model;

    public function init()
    {
        $this->_helper->authentication->checkAuthentication(false);
        $this->_model = new Model_User();
        parent::init();
    }

    public function indexAction()
    {
        
    }

}