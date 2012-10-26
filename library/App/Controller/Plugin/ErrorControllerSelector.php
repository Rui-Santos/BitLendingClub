<?php

class App_Controller_Plugin_ErrorControllerSelector extends Zend_Controller_Plugin_Abstract {
    
    public function routeShutdown(Zend_Controller_Request_Abstract $request) {
        $front = Zend_Controller_Front::getInstance();

        // If the ErrorHandler plugin is not registered, bail out  
        if (!($front->getPlugin('Zend_Controller_Plugin_ErrorHandler') instanceOf Zend_Controller_Plugin_ErrorHandler))
            return;

        $error = $front->getPlugin('Zend_Controller_Plugin_ErrorHandler');

        // Generate a HTTP request to use to determine if the error controller in our module exists  
        $httpRequest = new Zend_Controller_Request_HTTP();
        $httpRequest->setModuleName($request->getModuleName())
                ->setControllerName($error->getErrorHandlerController())
                ->setActionName($error->getErrorHandlerAction());

        // Does the controller even exist?  
        if ($front->getDispatcher()->isDispatchable($httpRequest)) {
            $error->setErrorHandlerModule($request->getModuleName());
        }
    }

}