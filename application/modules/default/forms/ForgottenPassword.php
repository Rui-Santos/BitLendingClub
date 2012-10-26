<?php

class Default_Form_ForgottenPassword extends Default_Form_Abstract
{

    public function init()
    {
        $recordExistsValidator = new App_Validate_NoRecordExists('Entity_Users', 'email');
        $recordExistsValidator->setMessage('This e-mail does not exists in the system.', App_Validate_NoRecordExists::ITEM_NOT_EXISTS);
        
        $this->addElement('text', 'email', array(
            'label' => 'E-mail',
            'class' => 'medium',
            'filters' => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
                $recordExistsValidator,
            ),
            'required' => true,
        ));
        
        $this->addElement('button', 'send', array(
            'label' => 'Send',
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
            array('HtmlTag', array('tag' => 'dd')),
            array('Label', array('tag' => 'dt', 'requiredSuffix' => '<span class="required">*</span>', 'escape' => false)),
        ));

        return $element;
    }
}
