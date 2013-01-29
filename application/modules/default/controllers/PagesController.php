<?php

class Default_PagesController extends Zend_Controller_Action
{

    public function init()
    {
      
    }

    public function indexAction()
    {
        $pageModel = new Model_Page();
        
       // $pageId = (int)$this->_request->getParam('pid', 0);
       // Zend_Debug::dump($this->_request->getParams());exit;
        $currentPage = $pageModel->getPage(array('slug'=>$this->_request->getParam('slug', 0)));
        
        $this->view->currentPage = $currentPage;
        
    }
     

}

