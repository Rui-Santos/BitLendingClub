<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initHelpers()
    {        
        $helper = new App_Controller_Action_Helper_Filters();
        Zend_Controller_Action_HelperBroker::addHelper($helper);

    }
}
