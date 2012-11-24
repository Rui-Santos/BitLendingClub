<?php

class Entity_Proxy_Users {
    protected $_id;
    protected $_firstname;
    protected $_lastname;
    protected $_roleName;
    protected $_debitAmount;
    protected $_socialAccountType;
    protected $_twitterAccessToken;    
    
    public function __construct(Entity_Users $obj)
    {
        $this->setId($obj->getId());
        $this->setFirstname($obj->getFirstname());
        $this->setLastname($obj->getLastname());
        $this->setRoleName($obj->getRole()->getName());
        
        
    }
    
    public function setId($id)
    {
        $this->_id = $id;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function setFirstname($name)
    {
        $this->_firstname = $name;
    }
    
    public function getFirstname()
    {
        return $this->_firstname;
    }
    
    public function setLastname($name)
    {
        $this->_lastname = $name;
    }
    
    public function getLastname()
    {
        return $this->_lastname;
    }
    
    public function getFullname()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }
    
    public function setRoleName($name)
    {
        $this->_roleName = $name;
    }
    
    public function getRoleName()
    {
        return $this->_roleName;
    }
    
    public function setDebitAmount($amount)
    {
        $this->_debitAmount = $amount;
    }
    
    public function getDebitAmount()
    {
        return $this->_debitAmount;
    }
    
    public function setSocialAccountType($type)
    {
        $this->_socialAccountType = $type;
    }
    
    public function getSocialAccountType()
    {
        $this->_socialAccountType;
    }
    
    public function setTwitterAccessToken($token)
    {
        $this->_twitterAccessToken;
    }
    
    public function getTwitterAccessToken()
    {
        return $this->_twitterAccessToken;
    }
}