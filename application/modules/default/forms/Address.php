<?php

class Default_Form_Address extends Admin_Form_Abstract {

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
                ->setRequired(true)
                ->addValidator('Size', false, array('max' => '5242880'))
                ->setDestination(realpath($config->paths->validate_files));
        $this->addElement($file);

        $this->addElement('button', 'save', array(
            'label' => 'Update',
            'type' => 'submit',
            'class' => 'button',
        ));

        $view = $this->getView();
        $url = $view->url(array('module' => 'default', 'controller' => 'rating', 'action' => 'address'), null, true);

        $this->addElement('button', 'cancel', array(
            'label' => 'Cancel',
            'onClick' => 'javascript:return window.location.href = \'' . $url . '\'; ',
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