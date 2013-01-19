<?php

class Default_PagesController extends Zend_Controller_Action
{

    public function init()
    {
      
    }

    public function indexAction()
    {
        $pageModel = new Model_Page();
        
        $pageId = (int)$this->_request->getParam('pid', 0);
        
        $currentPage = $pageModel->getPage(array('id'=>$pageId));
        
        $this->view->currentPage = $currentPage;
        
    }
     

}

