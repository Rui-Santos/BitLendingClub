<?php

abstract class App_Mail_Template_Abstract
{
    protected $_templateVars = array();
        
    public function __set($name, $value)
    {
        $this->_templateVars[$name] = $value;
    }     
    
    public function build()
    {                
        $view = new Zend_View();
        $view->setScriptPath(APPLICATION_PATH . '/modules/default/views/mails/');
        
        foreach ($this->_templateVars as $key=>$value) {
            $view->{$key} = $value;
        }
        
        return $view->render($this->getTemplateName());
    }
    
    protected function getTemplateName()
    {
        $fullClassName = get_class($this);
        $classSplit = explode('_', $fullClassName);
        $className = end($classSplit);
        $className = preg_replace('/([a-z0-9])(?=[A-Z])/', '$1-', $className);
        $className = trim($className, '-');
        return strtolower($className) . '.phtml';
    }
}
