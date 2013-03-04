<?php

class Default_Form_Settings extends Default_Form_Abstract
{

    public function __construct($options = null)
    {

        parent::__construct($options);
    }

    public function init()
    {
        $recordExistsValidator = new App_Validate_RecordExists('Entity_Users', 'email');
        $recordExistsValidator->setMessage('This e-mail already in use! Please choose another.', App_Validate_RecordExists::ITEM_EXISTS);

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

        $this->addElement('password', 'password', array(
            'label' => 'Password',
            'class' => 'medium',
            'required' => false,
            'validators' => array(
                array('StringLength', true, array('min' => 6)),
            ),
        ));

        $identicalValidator = new Zend_Validate_Identical();
        $identicalValidator->setToken('password');
        $identicalValidator->setMessage('Password confirmation does not match!', Zend_Validate_Identical::NOT_SAME);

        $this->addElement('password', 'password_confirm', array(
            'label' => 'Confirm Password',
            'class' => 'medium',
            'required' => false,
            'validators' => array(
                $identicalValidator,
            )
        ));

        $this->addElement('text', 'firstname', array(
            'label' => 'First name',
            'class' => 'medium',
            'filters' => array('StringTrim'),
            'required' => false,
        ));

        $this->addElement('text', 'lastname', array(
            'label' => 'Last name',
            'class' => 'medium',
            'filters' => array('StringTrim'),
            'required' => false,
        ));


        $this->addElement('text', 'address', array(
            'label' => 'Address',
            'class' => 'large',
            'required' => false,
        ));

        $this->addElement('text', 'username', array(
            'label' => 'Username',
            'class' => 'medium',
            'required' => false,
            'validators' => array(
                'Alpha'
            ),
        ));

//        $config = Zend_Registry::get('config');
//        $avatar = new Zend_Form_Element_File('avatar');
//        $avatar->setLabel('Upload an Avatar')
//            ->setDestination(realpath($config->paths->user_image))
//            ->setRequired(false)
//            ->setMaxFileSize(10240000) // limits the filesize on the client side
//            ->setDescription('Click Browse and click on the image file you would like to upload');
//        $avatar->addValidator('Count', false, 1);                // ensure only 1 file
//        $avatar->addValidator('Size', false, 10240000);            // limit to 10 meg
//        $avatar->addValidator('Extension', false, 'jpg,jpeg,png,gif'); // only JPEG, PNG, and GIFs
//        $this->addElement($avatar);

        $this->addElement('button', 'save', array(
            'label' => 'Update',
            'type' => 'submit',
            'class' => 'button',
        ));

        $view = $this->getView();
        $url = $view->url(array('module' => 'default', 'controller' => 'profile', 'action' => 'index'), null, true);

        $this->addElement('button', 'cancel', array(
            'label' => 'Cancel',
            'onClick' => 'javascript:return window.location.href = \'' . $url . '\'; ',
            'class' => 'button',
        ));

        $this->_applyDecorators();
    }

    protected function _applyTextDecorators($element)
    {
        $element->setDecorators(array(
            'ViewHelper',
            'Errors',
            'Label'
        ));

        return $element;
    }

    public function populate(array $values)
    {

        // Set required to false and description on password fields
        $passwordElement = $this->getElement('password');
        $passwordElement->setDescription("(Leave empty for no password changes)");
        $passwordElement->setRequired(false);

        $passwordConfirmElement = $this->getElement('password_confirm');
        $passwordConfirmElement->setRequired(false);

        parent::populate($values);
    }

}