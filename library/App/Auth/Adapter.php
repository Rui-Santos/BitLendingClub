<?php

class App_Auth_Adapter implements Zend_Auth_Adapter_Interface
{

    private $_email;
    private $_password;

    public function __construct($email, $password)
    {
        $this->_email = $email;
        $this->_password = md5($password);
    }

    public function authenticate()
    {        
        $userModel = new Model_User();
        $userItem = $userModel->authenticate($this->_email, $this->_password);
        
        if ($userItem) {
            // Increase login counter            
            $userItem = $userModel->incrementLoginCount($userItem->getId());
            
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, new Entity_Proxy_Users($userItem));
        } else {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, -1);
        }
    }

}