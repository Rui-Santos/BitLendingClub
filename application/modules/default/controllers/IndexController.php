<?php

/**
 * 
 */
class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
      
    }

    public function indexAction()
    {
      
      $registerForm = new Default_Form_Register(array('disableLoadDefaultDecorators' => true));

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            
            if ($registerForm->isValid($post)) {
               
                $dataValues = $registerForm->getValues();

                $userModel = new Model_User();
                $userItem = $userModel->create($dataValues);

                if ($userItem) {
                    $this->_helper->redirector('index', 'index');

                    //$this->_model->confirmRegistration($userItem->getId());
                }
            }
        }

        $this->view->form = $registerForm;
       
        $criteria = array();
        $loanModel = new Model_Loan();
        $paginator = new Zend_Paginator(
                        new App_Paginator_Adapter_Doctrine($loanModel->getAll($criteria)));
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(5);

        $this->view->loans = $paginator;
    }  
    
}