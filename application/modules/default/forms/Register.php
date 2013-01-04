<?php

class Default_Form_Register extends Default_Form_Abstract
{
    protected $_registerFinal = false;

    public function init()
    {
        $recordExistsValidator = new App_Validate_RecordExists('Entity_Users', 'email');
        $recordExistsValidator->setMessage('This e-mail already in use! Please choose another.', App_Validate_RecordExists::ITEM_EXISTS);
        
        $this->addElement('text', 'email', array(
            'label' => 'E-mail',
            'placeholder' => 'Email',
            'class' => 'medium',
            'filters' => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
                $recordExistsValidator,
            ),
            'required' => true,
        ));
       
        $this->addElement('password', 'password', array(
            'label' => 'Password',
            'placeholder' => 'Password',
            'class' => 'medium',
            'required' => true,
            'validators' => array(
                array('StringLength', true, array('min' => 6)),
            ),            
        ));
        
        $identicalValidator = new Zend_Validate_Identical();
        $identicalValidator->setToken('password');
        $identicalValidator->setMessage('Password confirmation does not match!', Zend_Validate_Identical::NOT_SAME);
        
        $this->addElement('password', 'password_confirm', array(
            'label' => 'Confirm Password',
            'placeholder' => 'Confirm Password',
            'class' => 'medium',
            'required' => true,
            'validators' => array(
                $identicalValidator,
            )
        ));

        $this->addElement('text', 'firstname', array(
            'label' => 'First name',
            'placeholder' => 'First name',
            'class' => 'medium',
            'filters' => array('StringTrim'),
            'required' => true,
        ));        

        $this->addElement('text', 'lastname', array(
            'label' => 'Last name',
            'placeholder' => 'Last name',
            'class' => 'medium',
            'filters' => array('StringTrim'),            
            'required' => true,
        )); 
        
        $this->addElement('text', 'address', array(
            'label' => 'Address',
            'placeholder' => 'Address',
            'class' => 'large',    
            'required' => true,
        ));        
        
        $this->addElement('text', 'username', array(
            'label' => 'Username',
            'placeholder' => 'Username',
            'class' => 'medium',
            'required' => true,
        ));        
        
        
//        $captcha = new Zend_Form_Element_Captcha('captcha', array(
//            'required' => true,
//            'captcha' => array(
//                'captcha' => 'Image',
//                'font' => APPLICATION_PATH . '/data/fonts/arial.ttf',
//                'fontSize' => 24,
//                'wordLen' => 5,
//                'height' => 60,
//                'width' => 258,
//                'imgDir' => APPLICATION_PATH . '/../public/data/captcha',
//                'imgUrl' => Zend_Controller_Front::getInstance()->getBaseUrl() . '/data/captcha',
//                'dotNoiseLevel' => 50,
//                'lineNoiseLevel' => 5
//            )
//        ));
//
//        $captcha->setLabel('Captcha:');
//        $this->addElement($captcha);
        
       
        $this->addElement('button', 'register', array(
            'label' => 'Register',
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
    
    public function setRegisterFinal($isFinal)
    {
        $this->_registerFinal = $isFinal;
    }
    
    public function getRegisterFinal()
    {
        return $this->_registerFinal;
    }
}
