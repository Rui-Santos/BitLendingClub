<?php

class Admin_Form_User extends Admin_Form_Abstract
{
    protected $_rolesOpts = array();
    protected $_recordExistsValidator;
    
    public function __construct($options = null)
    {
        if (isset($options['rolesOpts'])) {
            $this->_rolesOpts = $options['rolesOpts'];
        }
        
        parent::__construct($options);
    }

    public function init()
    {
        $this->_recordExistsValidator = new App_Validate_RecordExists('Entity_Users', 'email');
        $this->_recordExistsValidator->setMessage(
                'This e-mail already in use! Please choose another.', App_Validate_RecordExists::ITEM_EXISTS);
        
        $this->addElement('text', 'email', array(
            'label' => 'E-mail',
            'class' => 'medium',
            'validators' => array('EmailAddress'),
            'filters' => array('StringTrim'),
            'validators' => array(
                $this->_recordExistsValidator,
            ),
            'required' => true,
        ));
       
        $this->addElement('password', 'password', array(
            'label' => 'Password',
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
            'class' => 'medium',
            'required' => true,
            'validators' => array(
                $identicalValidator,
            )
        ));
        
        $this->addElement('text', 'firstname', array(
            'label' => 'First name',
            'class' => 'medium',
            'filters' => array('StringTrim'),
            'required' => true,
        ));        

        $this->addElement('text', 'lastname', array(
            'label' => 'Last name',
            'class' => 'medium',
            'filters' => array('StringTrim'),            
            'required' => true,
        )); 
        
//        $this->addElement('select', 'role_id', array(
//            'label' => 'User Role',
//            'class' => 'small',
//            'required' => true,
//            'id' => 'role_id',
//            'multiOptions' => $this->_rolesOpts,
//        ));        
        
        $this->addElement('text', 'address', array(
            'label' => 'Address',
            'class' => 'large',            
        ));        
        
        $this->addElement('text', 'username', array(
            'label' => 'Username',
            'class' => 'medium',
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
            'label' => 'Save',
            'type' => 'submit',
            'class' => 'button',
        ));
        
        $view = $this->getView();
        $url = $view->url(array('module' => 'admin', 'controller' => 'users', 'action' => 'index'), null, true);

        $this->addElement('button', 'cancel', array(
            'label' => 'Cancel',
            'onClick' => 'javascript:return window.location.href = \'' . $url . '\'; ',
            'class' => 'button',
        ));
        
        $this->_applyDecorators();
    }

    public function populate(array $values)
    {
        $this->_recordExistsValidator->setExcludeValue($values['email']);
        
        // Set required to false and description on password fields
        $passwordElement = $this->getElement('password');
        $passwordElement->setDescription("(Leave empty for no password changes)");
        $passwordElement->setRequired(false);
        
        $passwordConfirmElement = $this->getElement('password_confirm');
        $passwordConfirmElement->setRequired(false);
        
        parent::populate($values);
    }
}