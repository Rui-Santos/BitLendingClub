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
        
        //document type id
        $doctype = new Model_DocumentType();
        $doctype = $doctype->get(1);
        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($this->_model->getAll(array('user' => $user,'documentType'=>$doctype))));

        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->documents = $paginator;
       
    }  
    
    public function addressAction()
    {
        $user = new Model_User();
        $user = $user->getUser(array('id' => Service_Auth::getLoggedUser()->getId()));
        
        //document type address
        $doctype = new Model_DocumentType();
        $doctype = $doctype->get(2);
        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($this->_model->getAll(array('user' => $user,'documentType'=>$doctype))));

        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->documents = $paginator;
       
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
                    $this->_helper->redirector('index');
                }
            }
        }

        $this->view->assign(array('form' => $form, 'id' => $id));
    }
    
    public function uploadIdAction(){
        
        $id = Service_Auth::getLoggedUser()->getId();
       
        $form = new Default_Form_Id();
        
        $userItem = $this->_model->get($id);
       
        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
          
            if ($form->isValid($post)) {
                $userItem = $this->_model->uploadId($form->getValues(), $id);
                
                if ($userItem) {
                    $this->_helper->redirector('index');
                }
            }
        }

        $this->view->assign(array('form' => $form, 'id' => $id));
        
    }
}