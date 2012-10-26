<?php

class Service_Auth extends Zend_Service_Abstract
{

    /**
     *
     * @var MB_Model $_instance
     */
    protected static $_instance;

    protected static $_em = null;
    
    protected function __construct()
    {        
    }
    
    /**
     *
     * @return type 
     */
    public function getInstance()
    {
        
        if (self::$_em == null) {
            self::$_em = Zend_Registry::get('em');
        }
        
        if (self::$_instance) {
            return self::$_instance;
        } else {
            self::$_instance = new self();
            return self::$_instance;
        }
    }
    
    /**
     *
     * @return int 
     */
    public static function getId()
    {
        if (self::isLogged()) {
            return Zend_Auth::getInstance()->getIdentity()->getId();
        }
        
        return 0;
    }    

    /**
     * static method to be used to check the auth 
     * @return boolean $flag
     */
    public static function isLogged()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return true;
        }
        return false;
    }
    
    /**
     *
     * @return boolean 
     */
    public static function isLoggedAdmin()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $userIdentity = Zend_Auth::getInstance()->getIdentity();
                    
            return (bool) ($userIdentity->getRoleName() == Model_User::ADMIN_ROLE);
        }
        
        return false;
    }
    
    /**
     *
     * @return boolean 
     */
    public static function isLoggedReseller()
    {
        
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $userIdentity = Zend_Auth::getInstance()->getIdentity();
            
            return (bool) ($userIdentity->getRoleName() == Model_User::RESELLER_ROLE);
        }        
        
        return false;
    }
    
    /**
     *
     * @return boolean 
     */
    public static function getLoggedUser()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            return Zend_Auth::getInstance()->getIdentity();
        }
        
        return false;
    }
    
    /**
     *
     * @return boolean 
     */
    public static function logoutUser()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Auth::getInstance()->clearIdentity();
            
            return true;
        }
        
        return false;
    }

}