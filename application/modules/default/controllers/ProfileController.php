<?php

/**
 * 
 */
class Default_ProfileController extends Zend_Controller_Action {

    /**
     *
     * @var type
     */
    protected $_model;

    public function init() {
        $this->_helper->authentication->checkAuthentication(false);
        $this->_model = new Model_User();
    }

    public function indexAction() {
        $id = Service_Auth::getLoggedUser()->getId();
        $user = $this->_model->get($id);
        $this->view->user = $user;

        $validated = 0;
        $validatedAddress = 0;
        $validatedId = 0;
        $wallet = new Model_Wallet();
        $wallets = $wallet->findBy(array('user' => $user->getId()));
        $this->view->wallets = $wallets;

        $loans = new Model_Loan();
        $loans = $loans->findBy(array('borrower' => $user->getId()));
        $this->view->loans = $loans;

        $investments = new Model_Investment();
        $investments = $investments->findBy(array('investor' => $user->getId()));
        $this->view->investments = $investments;

        $documents = new Model_Document();
        $doctype = new Model_DocumentType();
        $doctypeId = $doctype->get(1);
        $docs = $documents->findBy(array('user' => $id, 'isReviewed' => 1));
        if (count($docs) > 0):
            foreach ($docs as $doc):
                $validated++;
                if ($doc->getDocumentType() === $doctypeId):
                    $validatedId = 1;
                else:
                    $validatedAddress = 1;
                endif;
            endforeach;
        endif;
        if ($user->getFbUserId()):
            $validated++;
        endif;
        $this->view->validated = $validated;
        $this->view->valId = $validatedId;
        $this->view->valAddress = $validatedAddress;
        //Zend_Debug::dump(Zend_Auth::getInstance()->getIdentity());
    }

    public function dashboardAction() {
        
    }

    public function settingsAction() {
        $id = Service_Auth::getLoggedUser()->getId();

        $form = new Default_Form_Settings();

        $userItem = $this->_model->get($id);

        $form->populate($userItem->toArray());

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            if ($form->isValid($post)) {
                $userItem = $this->_model->update($form->getValues(), $id);

                if ($userItem) {
                    $this->_helper->redirector('index');
                }
            }
        }

        $this->view->assign(array('form' => $form, 'id' => $id));
    }

    public function creditRatingAction() {
        
    }

    public function reputationAction() {
        $id = Service_Auth::getLoggedUser()->getId();



        $userItem = $this->_model->get($id);

        $this->view->user = $userItem;
    }

    public function investmentsAction() {
        $id = Service_Auth::getLoggedUser()->getId();
        $userItem = $this->_model->get($id);

        $loanModel = new Model_Investment();

        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($loanModel->getAll(array('investor' => $userItem))));

        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->investments = $paginator;
    }

    public function loansAction() {
        $id = Service_Auth::getLoggedUser()->getId();
        $userItem = $this->_model->get($id);

        $loanModel = new Model_Loan();

        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($loanModel->getAll(array('borrower' => $userItem))));

        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->loans = $paginator;
    }

    public function paymentsAction() {
        $id = Service_Auth::getLoggedUser()->getId();



        $userItem = $this->_model->get($id);
    }

    public function fundAction() {
        $id = Service_Auth::getLoggedUser()->getId();

        $this->_helper->layout->disableLayout();

        $walletModel = new Model_Wallet();

        $wallet = $walletModel->getWallet(array('user' => $id));


        $this->view->wallet = $wallet;
    }

    public function withdrawAction() {
        $this->_helper->layout->disableLayout();
        $id = Service_Auth::getLoggedUser()->getId();
        $withdrawForm = new Default_Form_Withdraw();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($withdrawForm->isValid($post)) {

                $values = $withdrawForm->getValues();

                $btcuser = Zend_Registry::get('config')->btc->conn->user;
                $btcpass = Zend_Registry::get('config')->btc->conn->pass;
                $btcurl = Zend_Registry::get('config')->btc->conn->host;
                $bitcoin = new App_jsonRPCClient('http://' . $btcuser . ':' . $btcpass . '@' . $btcurl . '/');
                $isValid = $bitcoin->validateaddress($values['amount']);

                if ($isValid['isvalid']) {
                    $transfer = $bitcoin->sendfrom('account_' . $id, $values['address'], $values['amount']);
                    Zend_Debug::dump($transfer);
                    exit;
                    if ($transfer) {
                        $this->_helper->redirector('index', 'index');
                    } else {
                        $this->view->errorWithdrawAddress = true;
                    }
                } else {
                    $this->view->errorWithdraw = true;
                }
            } else {
                $this->view->errorWithdraw = true;
            }
        }

        $this->view->form = $withdrawForm;
    }

}