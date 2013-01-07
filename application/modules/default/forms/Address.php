<?php

class Default_Form_Address extends Default_Form_Abstract {

    public function __construct($options = null) {

        parent::__construct($options);
    }

    public function init() {
        $config = Zend_Registry::get('config');
        $this->addElement('hidden', 'user_id', array(
            'value' => Service_Auth::getLoggedUser()->getId(),
        ));

        $this->addElement('hidden', 'doctype', array(
            'value' => '2',
        ));


        $file = new Zend_Form_Element_File('file');
        $file->setLabel('Upload a file: ')
                ->setRequired(false)
                ->addValidator('Size', false, array('max' => '5242880'))
                ->setDestination(realpath($config->paths->temp_dir));
        $this->addElement($file);

        $this->addElement('button', 'save', array(
            'label' => 'Upload',
            'type' => 'submit',
            'class' => 'button',
        ));


        $this->_applyDecorators();
    }

    protected function _applyTextDecorators($element) {
        $element->setDecorators(array(
            'ViewHelper',
            'Errors',
            'Label'
        ));

        return $element;
    }

}