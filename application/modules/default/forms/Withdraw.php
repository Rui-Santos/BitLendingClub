<?php

class Default_Form_Withdraw extends Default_Form_Abstract
{

    public function init()
    {
        $user = new Model_User();
        $user = $user->get(Service_Auth::getLoggedUser()->getId());
        $this->addElement('text', 'amount', array(
            'label' => 'Amount of bitcoins',
            'placeholder' => 'Amount of bitcoins',
            'class' => 'medium',
            'required' => true,
        ));        

        $this->addElement('text', 'address', array(
            'label' => 'BTC Address',
            'placeholder' => 'BTC Address',
            'class' => 'medium',
            'filters' => array('StringTrim'),            
            'required' => true,
            'value' => $user->getAddress(),
        ));       

        $this->addElement('button', 'withdraw', array(
            'label' => 'Withdraw',
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
    
    
}
