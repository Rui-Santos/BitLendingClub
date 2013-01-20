<?php

class Default_Form_Loan extends Default_Form_Abstract
{
    
    public function __construct($options = null)
    {
       
        parent::__construct($options);
    }

    public function init()
    {
       
        
        
        $this->addElement('button', 'save', array(
            'label' => 'Update',
            'type' => 'submit',
            'class' => 'button',
        ));
        
        $view = $this->getView();
        $url = $view->url(array('module' => 'default', 'controller' => 'loan', 'action' => 'index'), null, true);

        $this->addElement('button', 'cancel', array(
            'label' => 'Cancel',
            'onClick' => 'javascript:return window.location.href = \'' . $url . '\'; ',
            'class' => 'button',
        ));
        
        $this->_applyDecorators();
    }
    
     protected function _applyTextDecorators($element)
    {
        $element->setDecorators(array(
            'ViewHelper',
            'Errors',
            'Label'
        ));

        return $element;
    }

   
}