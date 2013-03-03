<?php

class Default_AuthController extends Zend_Controller_Action {

    protected $_model;

    public function init() {
        $this->_model = new Model_User();
    }

    public function indexAction() {
        $this->_forward('login');
    }

    public function loginAction() {
        error_log("log in action");
        $this->_helper->layout->disableLayout();

        $loginForm = new Default_Form_Login();

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($loginForm->isValid($post)) {

                $values = $loginForm->getValues();

                $adapter = new App_Auth_Adapter($values['email'], $values['password']);
                $auth = Zend_Auth::getInstance();
                $result = $auth->authenticate($adapter);

                if ($result->isValid()) {
                    
                    // syncing for bitcoin api
                    Service_Bitcoind::getInstance()->sync(array('user_id' => Service_Auth::getId()));
                    
                    $this->_helper->viewRenderer->setNoRender(true);
                    $this->getResponse()->setHeader('Content-type', 'application/json;charset=UTF-8', true);
                    $this->getResponse()->setBody(json_encode(array("success" => "true")));
                } else {
                    $this->view->errorLoginCredentials = true;
                }
            }
        }
        $this->view->form = $loginForm;
    }

    public function facebookLoginAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $token = $this->getRequest()->getParam('token', false);
        if ($token == false) {
            throw new InvalidArgumentException('Missing token parameter');
        }

        $auth = Zend_Auth::getInstance();
        $adapter = new App_Auth_Adapter_Facebook($token);
        $result = $auth->authenticate($adapter);

        if ($result->isValid()) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function registerAction() {
        // $this->_helper->layout->disableLayout();

        $registerForm = new Default_Form_Register(array('disableLoadDefaultDecorators' => true));

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();

            if ($registerForm->isValid($post)) {
                $dataValues = $registerForm->getValues();

                $userModel = new Model_User();
                $userItem = $userModel->create($dataValues);

                if ($userItem) {
                    $this->render('register-final');

                    //$this->_model->confirmRegistration($userItem->getId());
                }
            }
        }

        $this->view->form = $registerForm;
    }

    public function logoutAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        Service_Auth::logoutUser();

        $this->_helper->redirector('index', 'index');
    }

}

