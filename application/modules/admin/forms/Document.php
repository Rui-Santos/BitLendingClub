<?php

class Admin_Form_Document extends Admin_Form_Abstract
{

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    public function init()
    {
        
        
        $this->addElement('button', 'save', array(
            'label' => 'Save',
            'type' => 'submit',
            'class' => 'button',
        ));
        
        $view = $this->getView();
        $url = $view->url(array('module' => 'admin', 'controller' => 'documents', 'action' => 'index'), null, true);

        $this->addElement('button', 'cancel', array(
            'label' => 'Cancel',
            'onClick' => 'javascript:return window.location.href = \'' . $url . '\'; ',
            'class' => 'button',
        ));
        
        $this->_applyDecorators();
    }

    public function populate(array $values)
    {
        
        parent::populate($values);
    }
}