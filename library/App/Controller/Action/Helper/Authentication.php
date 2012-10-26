<?php

class App_Controller_Action_Helper_Authentication extends Zend_Controller_Action_Helper_Abstract
{
    const PRE_FUNCTIONCALL = 'check';
    
    /**
     *
     * @param type $type
     * @throws Exception 
     */
    public function checkAuthentication($type = Model_User::REGULAR_ROLE)
    {
        $functionCall = join('', array(self::PRE_FUNCTIONCALL, ucfirst($type)));
        $response = call_user_func_array(array($this, $functionCall), array());
        
        if (!$response) {
            $this->getActionController()->getHelper('redirector')->gotoUrl(
                $this->getActionController()->view->url(array('module' => 'admin', 'controller' => 'auth'), null, true));
        }
    }
    /**
     *
     * @return type
     * @throws Exception 
     */
    public function checkRegular()
    {
        if (!Service_Auth::isLogged()) {
            return false;
        }
        
        return Service_Auth::isLogged();
    }
    
    /**
     *
     * @return type
     * @throws Exception 
     */
    public function checkReseller()
    {
        if (!Service_Auth::isLoggedReseller()) {
            return false;
        }
        
        return Service_Auth::isLoggedReseller();
    }
    
    public function checkAdmin()
    {
        return Service_Auth::isLogged();
    }

}