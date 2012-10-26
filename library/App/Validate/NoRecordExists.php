<?php

class App_Validate_NoRecordExists extends Zend_Validate_Abstract
{   
    protected $_repository;
    protected $_field;
    protected $_excludeValue;
    
    const ITEM_NOT_EXISTS = 'itemNotExists';
    
    protected $_messageTemplates = array(
        self::ITEM_NOT_EXISTS => 'This record not exists in the database.'
    );

    public function __construct($entityName, $field, $excludeValue = null) {
        $entityManager = Zend_Registry::get('em');
        $this->_repository = $entityManager->getRepository($entityName);
        $this->_field = $field;        
        $this->_excludeValue = $excludeValue;
    }
    
    public function setRepository($repository)
    {
        $this->_repository = $repository;
    }
    
    public function getRepository()
    {
        return $this->_repository;
    }
    
    public function setField($fieldName) 
    {
        $this->_field = $fieldName;
    }
    
    public function getField()
    {
        return $this->_field;
    }
    
    public function setExcludeValue($value)
    {
        $this->_excludeValue = $value;
    }
    
    public function getExcludeValue()
    {
        return $this->_excludeValue;
    }        

    public function isValid($value)
    {
        $value = (string) $value;
        $this->_setValue($value);

        $queryParams = array();
        $queryParams[$this->_field] = $value;
        
        if ($this->_excludeValue != null) {
            return ($value == $this->_excludeValue);
        }
        
        $result = $this->_repository->findBy($queryParams);

        if (count($result) == 0) {
            $this->_error(self::ITEM_NOT_EXISTS);
            return false;
        }

        return true;
    }
}