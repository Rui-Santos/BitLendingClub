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
        
        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($this->_model->getAll(array('user' => $user))));

        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->documents = $paginator;
       
    }  
    
    public function settingsAction() 
    {
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