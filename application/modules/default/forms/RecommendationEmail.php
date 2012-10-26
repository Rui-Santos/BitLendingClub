<?php

class Default_Form_RecommendationEmail extends Default_Form_Abstract
{

    public function init()
    {
        $this->addElement('text', 'email', array(
            'label' => "Email",
            'id' => 'email-id',
            'filters' => array('StringTrim'),
            'validators' => array('EmailAddress'),
            'required' => true,
        ));

        $this->addElement('textarea', 'link', array(
            'label' => 'Text',
            'id' => 'email-id',
            'cols' => '40',
            'rows' => '8',
            'required' => true,
        ));
        
        $this->addElement('hidden', 'token');

        $this->addElement('hidden', 'deal_id');
        
        $this->addElement('hidden', 'type');

        $this->addElement('button', 'send', array(
            'label' => 'Send',
            'type' => 'submit',
            'class' => 'button',
            'decorators' => array('ViewHelper'),
        ));

        $this->addElement('button', 'cancel', array(
            'label' => 'Cancel',
            'class' => 'button',
            'id' => 'register-email-cancel',
            'decorators' => array('ViewHelper'),
        ));

        $this->_applyDecorators();
    }

}