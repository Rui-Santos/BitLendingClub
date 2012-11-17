<?php

class Plugin_Layout extends Zend_Layout_Controller_Plugin_Layout
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {        
        $this->getLayout()->setLayoutPath(
            Zend_Controller_Front::getInstance()
                ->getModuleDirectory($request->getModuleName()) . '/views'
        );
        $this->getLayout()->setLayout('layout');
        
        // Adding cities for the filters in the header
        $view = $this->getLayout()->getView();
        
        $city = $request->getParam('city', 0);
        
        
        // Static Pages
//        $pageModel = new Model_Page();        
        //$view->headerNav = $pageModel->getByCategory(Model_Page::CATEGORY_HEADER);
        //$view->sidebarNav = $pageModel->getByCategory(Model_Page::CATEGORY_SIDEBAR);        
        //$view->footerNav = $pageModel->getByCategory(Model_Page::CATEGORY_FOOTER);
    }

}