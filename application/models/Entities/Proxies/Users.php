<?php

class Entity_Proxy_Users {
    protected $_id;
    protected $_firstname;
    protected $_lastname;
    protected $_roleName;
        
    
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

}