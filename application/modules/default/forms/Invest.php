<?php

class Default_Form_Invest extends Default_Form_Abstract
{

    public function init()
    {

        $this->addElement('text', 'amount', array(
            'label' => 'Amount of bitcoins',
            'placeholder' => 'Amount of bitcoins',
            'class' => 'medium',
            'filters' => array('StringTrim'),
            'required' => true,
        ));
        $this->addElement('hidden', 'loan_id', array(
        ));

        $this->addElement('hidden', 'user_id', array(
        ));

        $this->addElement('text', 'rate', array(
            'label' => 'Rate (%)',
            'placeholder' => 'Rate (%)',
            'class' => 'medium',
            'filters' => array('StringTrim'),
            'required' => true,
        ));

        $this->addElement('button', 'invest', array(
            'label' => 'Invest',
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
