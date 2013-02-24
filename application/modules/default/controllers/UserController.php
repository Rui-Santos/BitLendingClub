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

    public function rateAction()
    {

        $this->view->form = new Default_Form_RateUser();
        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($this->view->form->isValid($post)) {
                $values = $this->view->form->getValues();
                if ($this->_model->rateForUser($values)) {
                    $this->_helper->flashMessenger->addMessage("You successfully rated for the user");
                }
                
            }
        }
    }

}