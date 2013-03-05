<?php

/**
 *
 * @author Yasen Yankov
 *  
 */
class Default_Form_RateUser extends Default_Form_Abstract
{

    /**
     *
     * @var type 
     */
    protected $_usersOpts = array();

    public function __construct($options = null)
    {
        if (isset($options['usersOpts'])) {
            $this->_usersOpts = $options['usersOpts'];
        }
        parent::__construct($options);
    }

    public function init()
    {
        $element = new Zend_Form_Element_Select('user_id', array(
                    'multiOptions' => $this->_usersOpts,
                    'required' => true,
                    
                ));
        $this->addElement($element);

        $this->addElement('text', 'rating', array(
            'required' => true
        ));

        $element = new Zend_Form_Element_Textarea('comment', array());
        $this->addElement($element);


        $this->addElement('button', 'Rate', array(
            'type' => 'submit',
            'class' => 'button',
        ));

        $view = $this->getView();
        $url = $view->url(array('module' => 'default', 'controller' => 'index', 'action' => 'index'), null, true);

        $this->addElement('button', 'cancel', array(
            'label' => 'Cancel',
            'onClick' => 'javascript:return window.location.href = \'' . $url . '\'; ',
            'class' => 'button',
        ));

        $this->_applyDecorators();
    }

}
