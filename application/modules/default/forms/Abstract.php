<?php

abstract class Default_Form_Abstract extends Zend_Form
{

    /**
     * 
     */
    protected function _applyDecorators()
    {
        foreach ($this->getElements() as $element) {            
            if ($element instanceof Zend_Form_Element_Button) {
                $this->_applyButtonDecorators($element);
            } else if ($element instanceof Zend_Form_Element_File) {
                $this->_applyFileDecorators($element);
            } else if ($element instanceof Zend_Form_Element_Checkbox) { 
                $this->_applyCheckboxDecorators($element);
            } else if ($element instanceof Zend_Form_Element_Radio) {
                $this->_applyRadioDecorators($element);
            } else if ($element instanceof Zend_Form_Element_Captcha) {
                $this->_applyCaptchaDecorators($element);
            } else if ($element instanceof Zend_Form_Element_Hidden) {
                $this->_applyHiddenDecorators($element);
            } else {
                $this->_applyTextDecorators($element);
            }
        }
    }

    /**
     *
     * @param type $element
     * @return type 
     */
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

    /**
     *
     * @param type $element
     * @return type 
     */
    protected function _applyFileDecorators($element)
    {
        return $element;
    }

    /**
     *
     * @param type $element
     * @return type 
     */
    protected function _applyButtonDecorators($element)
    {
        $element->setDecorators(array(
            'ViewHelper',
        ));
        
        return $element;
    }
        
    /**
     *
     * @param type $element
     * @return type 
     */
    protected function _applyHiddenDecorators($element)
    {
        $element->setDecorators(array(
            'ViewHelper',
        ));
        
        return $element;
    }

    /**
     *
     * @param type $element
     * @return type 
     */    
    protected function _applyCheckboxDecorators($element)
    {
        return $element;
    }
    
    /**
     *
     * @param type $element
     * @return type 
     */    
    protected function _applyRadioDecorators($element)
    {
        return $element;
    }    

    /**
     *
     * @param type $element
     * @return type 
     */        
    protected function _applyCaptchaDecorators($element)
    {
        return $element;
    }

}