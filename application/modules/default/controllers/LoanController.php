<?php

/**
 * 
 */
class Default_LoanController extends Zend_Controller_Action {

    protected $_model;

    public function init() {
        $this->_model = new Model_Loan();
    }

    public function indexAction() {

        $criteria = array();

        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($this->_model->getAll($criteria)));
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(Model_Page::PER_PAGE);

        $this->view->loans = $paginator;
    }

    public function createAction() {
        
        
        if(!Service_Auth::getLoggedUser()){
            $this->_helper->redirector('index');
        }
        $form = new Default_Form_Loan(array('purposesOpts' => Model_Loan::$_purposesOpts));

        if ($this->_request->isPost()) {
            # adding the new entity after validating the input data
            $post = $this->_request->getPost();

            if ($form->isValid($post)) {
                $pageItem = $this->_model->create($form->getValues());

                if ($pageItem) {
                    $this->_helper->redirector('index');
                }
            }
        }

        $this->view->form = $form;
    }
    
     public function overviewAction() {
        $id = Service_Auth::getLoggedUser()->getId();
        $userItem = new Model_User();
        
        $userItem = $userItem->get($id);
        
        $loanModel = new Model_Loan();

        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($loanModel->getAll(array('borrower' => $userItem))));

        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->loans = $paginator;
    }
    
    public function browseAction() {
        
       $loanId = (int)$this->_request->getParam('lid', 0);
       
        $loan = $this->_model->getLoan(array('id'=>$loanId));
        $this->view->loan = $loan;
        
        $investments = new Model_Investment();
        $investments = $investments->findBy(array('loan' => $loanId));
        
        
        $comments = new Model_LoanComment();
        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($comments->getAll(array('loan'=>$loanId))));
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(5);

        $this->view->comments = $paginator;
        $this->view->investments = $investments;
    }

}