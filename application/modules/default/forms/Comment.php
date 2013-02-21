<?php

class Default_Form_Comment extends Default_Form_Abstract {

    public function __construct($options = null) {

        parent::__construct($options);
    }

    public function init() {
        $config = Zend_Registry::get('config');
        $this->addElement('hidden', 'user_id', array(
            'value' => Service_Auth::getLoggedUser()->getId(),
        ));

        $this->addElement('hidden', 'loan_id', array(
            'value' => (int)$this->_request->getParam('lid', 0),
        ));
        
        $this->addElement('textarea', 'comment', array(
            'class' => 'large ckeditor html_editor_on_simple',
            'cols' => 70,
            'rows' => 15,
            'placeholder' => 'Comment',
            'required' => true,
        ));
        
        $this->addElement('button', 'save', array(
            'label' => 'Submit',
            'type' => 'submit',
            'class' => 'button',
        ));


        $this->_applyDecorators();
    }

    protected function _applyTextDecorators($element) {
        $element->setDecorators(array(
            'ViewHelper',
            'Errors'
        ));

        return $element;
    }

}