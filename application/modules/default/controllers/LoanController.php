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

        $this->view->loanList = $paginator;
    }

    public function createAction() {
        $form = new Default_Form_Loan();

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

}