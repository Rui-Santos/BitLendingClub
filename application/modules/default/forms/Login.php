<?php

class Default_Form_Login extends Default_Form_Abstract
{

    public function init()
    {
        $this->addElement('text', 'email', array(
            'label' => 'E-mail',
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress'),
            'required' => true,
        ));

        $this->addElement('password', 'password', array(
            'label' => 'Password',
            'required' => true,
        ));
        
        $this->addElement('checkbox', 'remember_me', array(
            'label' => 'Remember me',
            'class' => 'checkbox',
        ));      

        $this->addElement('button', 'login', array(
            'label' => 'Login',
            'type' => 'submit',
            'class' => 'button',
            'decorators' => array('ViewHelper'),
        ));        
        
        $this->_applyDecorators();
    }
    
    protected function _applyTextDecorators($element)
    {
        $element->setDecorators(array(
            'ViewHelper',
            'Errors',
        ));

        return $element;
    }
    
    protected function _applyCheckboxDecorators($element)
    {
        $element->setDecorators(array(
            'ViewHelper',
            array('Label', array('placement' => 'APPEND', 'escape' => false)),
        ));

        return $element;        
    }    
}
