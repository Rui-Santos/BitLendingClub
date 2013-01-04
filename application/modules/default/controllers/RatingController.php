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
        
        //Zend_Debug::dump(Zend_Auth::getInstance()->getIdentity());
       
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