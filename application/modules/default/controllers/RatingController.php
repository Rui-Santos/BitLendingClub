<?php

/**
 * 
 */
class Default_RatingController extends Zend_Controller_Action
{

    /**
     *
     * @var type
     */
    protected $_model;

    public function init()
    {
        $this->_helper->authentication->checkAuthentication(false);
        $this->_model = new Model_Document();
    }

    public function indexAction()
    {
        $user = new Model_User();
        $user = $user->getUser(array('id' => Service_Auth::getLoggedUser()->getId()));
        $this->view->user = $user;
        $config = Zend_Registry::get('config');

        //document type id
        $doctype = new Model_DocumentType();
        $doctype = $doctype->get(1);
        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($this->_model->getAll(array('user' => $user, 'documentType' => $doctype))));

        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->documents = $paginator;
        $this->view->imagePath = $config->paths->validate_files;
    }

    public function addressAction()
    {
        $user = new Model_User();
        $user = $user->getUser(array('id' => Service_Auth::getLoggedUser()->getId()));

        $config = Zend_Registry::get('config');

        //document type address
        $doctype = new Model_DocumentType();
        $doctype = $doctype->get(2);
        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($this->_model->getAll(array('user' => $user, 'documentType' => $doctype))));
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->documents = $paginator;
        $this->view->imagePath = $config->paths->validate_files;
    }

    public function addressUploadAction()
    {
        $id = Service_Auth::getLoggedUser()->getId();

        $form = new Default_Form_Address();

        $document = $this->_model->get($id);



        if ($this->_request->isPost()) {

            $post = $this->_request->getPost();

            if ($form->isValid($post)) {
                $document = $this->_model->create($form->getValues(), $id);

                if ($document) {
                    $this->_helper->redirector('address');
                }
            }
        }

        $this->view->assign(array('form' => $form, 'id' => $id));
    }
    
    /**
     * 
     */
    public function idUploadAction()
    {
        $id = Service_Auth::getLoggedUser()->getId();
        $form = new Default_Form_Id();
        $document = $this->_model->get($id);
        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if ($form->isValid($post)) {
                $document = $this->_model->create($form->getValues(), $id);
                if ($document) {
                    $this->_helper->redirector('index');
                }
            }
        }
        $this->view->assign(array('form' => $form, 'id' => $id));
    }
    
    /**
     *
     * @throws InvalidArgumentException 
     */
    public function facebookValidateAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $token = $this->getRequest()->getParam('token', false);
        if ($token == false) {
            throw new InvalidArgumentException('Missing token parameter');
        }

        $auth = Zend_Auth::getInstance();
        $adapter = new App_Auth_Adapter_Facebook($token);
        $adapter->validate();


        $this->_helper->redirector('index', 'rating');
    }

}