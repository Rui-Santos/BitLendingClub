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
        
        
        
        
        $paginator = Zend_Paginator::factory($this->_model->getRatingsAsArray($this->view->user));
        $paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
        
        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->ratings = $paginator;
        
        if (!$this->view->user) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function rateAction()
    {
        
        if (!Service_Auth::getLoggedUser()) {
            $this->_helper->redirector('index');
        }
        
        
        $usersOpts = $this->_model->getUserOpts();
        
        $this->view->user = $this->_model->getUser(array('id'=>Service_Auth::getLoggedUser()->getId()));
        
        $this->view->form = new Default_Form_RateUser(array('usersOpts' => $usersOpts));
        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($this->view->form->isValid($post)) {
                $values = $this->view->form->getValues();
                if ($this->_model->rateForUser($values)) {
                    $this->_helper->flashMessenger->addMessage("You successfully rated for the user");
                    $this->_helper->redirector('index', 'index');
                }
            }
        }
    }

}