<?php

class Default_Form_Loan extends Default_Form_Abstract
{
    /**
     *
     * @var type 
     */
    protected $_purposesOpts = array();

    public function __construct($options = null)
    {
        if (isset($options['purposesOpts']) && !empty($options['purposesOpts'])) {
            $this->_purposesOpts = $options['purposesOpts'];
        }
        parent::__construct($options);
    }

    public function init()
    {

        $this->addElement('hidden', 'user_id', array(
            'value' => Service_Auth::getLoggedUser()->getId(),
        ));

        $this->addElement('text', 'title', array(
            //'placeholder' => 'Title',
            'required' => true,
        ));

        $this->addElement('text', 'term', array(
            //'placeholder' => 'Term (days)',
//            'label' => 'Term (days)',
            'class' => 'input-short',
            'required' => true,
        ));

        $element = new Zend_Form_Element_Select('purpose', array(
                    'multiOptions' => $this->_purposesOpts
                ));

        $this->addElement($element);

        $this->addElement('text', 'amount', array(
            //'placeholder' => 'Amount',
//            'label' => 'Amount',
            'class' => 'input-short',
            'required' => true,
        ));

        $this->addElement('text', 'frequency', array(
            //'placeholder' => 'Payment Frequency',
//            'label' => 'Payment Frequency',
            'class' => 'medium',
            'required' => true,
        ));

        $this->addElement('text', 'expirationDate', array(
            'class' => 'datepicker',
//            'label' => 'Expiration date',
            'required' => true,
            'readonly' => true,
        ));

        $this->addElement("textarea", 'description', array(
            'class' => 'large ckeditor html_editor_on_simple',
            'cols' => 70,
            'rows' => 15,
            //'placeholder' => 'Description',
//            'label' => 'Description',
            'required' => true,
        ));


        $this->addElement('button', 'save', array(
            'type' => 'submit',
            'class' => 'button',
        ));

        $view = $this->getView();
        $url = $view->url(array('module' => 'default', 'controller' => 'loan', 'action' => 'index'), null, true);

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

}
