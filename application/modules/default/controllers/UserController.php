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
        $id = $this->_request->getParam('id', 0);
        if ($id == 0) {
            throw new HttpException('Invalid http get parameter');
        }
        $this->view->user = $this->_model->get($id);
        if (!$this->view->user) {
            $this->_helper->redirector('index', 'index');
        }
        
//        App_DoctrineDebug::dump($this->view->user->getLoans()); exit;
    }

}