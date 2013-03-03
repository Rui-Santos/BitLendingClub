<?php

/**
 * 
 */
class Default_LoanController extends Zend_Controller_Action
{

    protected $_model;

    public function init()
    {
        $this->_model = new Model_Loan();
    }

    public function indexAction()
    {

        $criteria = array('status' => 1);

        $paginator = new Zend_Paginator(
                new App_Paginator_Adapter_Doctrine($this->_model->getAll($criteria)));
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(Model_Page::PER_PAGE);

        $this->view->loans = $paginator;
    }

    public function createAction()
    {


        if (!Service_Auth::getLoggedUser()) {
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

    public function overviewAction()
    {
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

    public function browseAction()
    {

        $loanId = (int) $this->_request->getParam('lid', 0);

        $loan = $this->_model->getLoan(array('id' => $loanId));
        $this->view->loan = $loan;

        $activeLoans = $this->_model->findBy(array('borrower' => $loan->getBorrower()->getId(), 'status' => Model_Loan::STATUS_ACTIVE));
        $this->view->activeLoans = count($activeLoans);
        
        $repaidLoans = $this->_model->findBy(array('borrower' => $loan->getBorrower()->getId(), 'status' => Model_Loan::STATUS_REPAIED));
        $this->view->repaidLoans = count($repaidLoans);
        
        $investments = new Model_Investment();
        $investments = $investments->findBy(array('loan' => $loanId));
        $this->view->investments = $investments;
        if (Service_Auth::getLoggedUser()) {
            $commentForm = new Default_Form_Comment(array('disableLoadDefaultDecorators' => true));
            $this->view->form = $commentForm;
        }
        $comments = new Model_LoanComment();
        $paginator = new Zend_Paginator(
                new App_Paginator_Adapter_Doctrine($comments->getAll(array('loan' => $loanId))));
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(5);
        $this->view->comments = $paginator;

        $invAmount = $this->_model->getInvestmentsAmount($loan->getInvestments());
        $this->view->investedAmount = $invAmount;
        if (Service_Auth::getLoggedUser()) {
            if ($loan->getBorrower()->getId() == Service_Auth::getLoggedUser()->getId()) {
                $this->view->canEdit = true;
            } else {
                $this->view->canEdit = false;
            }
        }
    }

    public function commentAction()
    {
        $this->_helper->layout->disableLayout();
        $commentForm = new Default_Form_Comment(array('disableLoadDefaultDecorators' => true));
        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            if ($commentForm->isValid($post)) {

                $dataValues = $commentForm->getValues();

                $commentModel = new Model_LoanComment();
                $commentItem = $commentModel->create($dataValues);

                if ($commentItem) {
                    $this->_helper->redirector('browse', 'loan', null, array('lid' => $post['loan_id']));

                    //$this->_model->confirmRegistration($userItem->getId());
                }
            }
        }
    }

    public function investAction()
    {
        $this->_helper->layout->disableLayout();
        $loanId = (int) $this->_request->getParam('lid', 0);
        $this->view->loanId = $loanId;

        $id = Service_Auth::getLoggedUser()->getId();
        $this->view->userId = $id;

        $investForm = new Default_Form_Invest();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($investForm->isValid($post)) {

                $values = $investForm->getValues();
                $invModel = new Model_Investment();
                $invItem = $invModel->create($values);
                if ($invItem) {
                    $this->_helper->viewRenderer->setNoRender(true);
                    $this->getResponse()->setHeader('Content-type', 'application/json;charset=UTF-8', true);
                    $this->getResponse()->setBody(json_encode(array("success" => "true")));
                }
            } else {
                $this->view->errorInvest = true;
            }
        }

        $this->view->form = $investForm;
    }

    public function deleteInvestmentAction()
    {
        # fetching the id and checks 
        $id = $this->_request->getParam('iid', 0);
        if (intval($id) == 0) {
            throw new InvalidArgumentException('Invalid request parameter: $id');
        }
        $invModel = new Model_Investment();
        $invItem = $invModel->getInvestment(array('id' => $id));
        if ($this->_request->getParam('borrower', 0)) {
            if ($invItem->getLoan()->getBorrower()->getId() != Service_Auth::getLoggedUser()->getId()) {
                throw new InvalidArgumentException('This is not your loan!');
            }
        } else {
            if ($invItem->getInvestor()->getId() != Service_Auth::getLoggedUser()->getId()) {
                throw new InvalidArgumentException('This is not your investment!');
            }
        }
        $invItem = $invModel->delete($id);
        if ($invItem) {
            if ($this->_request->getParam('borrower', 0)) {
                $this->_helper->redirector('browse', 'loan', null, array('lid' => $invItem->getLoan()->getId()));
            } else {
                $this->_helper->redirector('investments', 'profile');
            }
        }
    }

    public function finalizeAction()
    {
        $loanId = (int) $this->_request->getParam('lid', 0);
        if (intval($loanId) == 0) {
            throw new InvalidArgumentException('Invalid request parameter: loan id');
        }

        $loan = $this->_model->getLoan(array('id' => $loanId));

        if ($loan->getBorrower()->getId() != Service_Auth::getLoggedUser()->getId()) {
            throw new InvalidArgumentException('This is not your loan!');
        }

        if ($loan->getAmount() != Model_Loan::getInvestmentsAmount($loan->getInvestments())) {
            throw new InvalidArgumentException('This loan is not 100% funded!');
        }

        $this->_model->finalizeLoan($loanId);
    }

    /**
     * 
     */
    public function repayAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $loanId = (int) $this->_request->getParam('lid', 0);
        
        $result = $this->_model->repay($loanId);
        if (!$result) {
            throw new Exception('Invalid result of repayment of loan'. $loanId);
        }
        Zend_Debug::dump($loanId);
        
    }

}