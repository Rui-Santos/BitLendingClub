<?php

class Admin_Form_Page extends Admin_Form_Abstract
{

    protected $_categories = array();

    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    public function init()
    {
        $this->addElement('text', 'title', array(
            'label' => 'Title',
	     'id' => 'control',
            'class' => 'input-xlarge focused',
            'required' => true,
        ));    
        
        $this->addElement('text', 'slug', array(
            'label' => 'Slug',
	     'id' => 'control',
            'class' => 'input-xlarge focused',
            'required' => true,
        ));     

        $this->addElement('textarea', 'content', array(
	     'class' => 'input-xlarge ckeditor html_editor_on_simple',
	     'id' => 'control content',
            'cols' => 70,
            'rows' => 15,
            'label' => 'Content',
            'required' => true,
        ));            
        
        $this->addElement('text', 'meta_keywords', array(
	     'id' => 'control',
            'class' => 'input-xlarge focused',
            'label' => 'Meta keywords',
        ));

        $this->addElement('text', 'meta_description', array(
	     'id' => 'control',
            'class' => 'input-xlarge focused',
            'label' => 'Meta description',
        ));          
        
        $this->addElement('button', 'save', array(
            'label' => 'Submit',
            'type' => 'submit',
            'class' => 'btn btn-primary',
        ));
              

        $this->_applyDecorators();
    }

}
