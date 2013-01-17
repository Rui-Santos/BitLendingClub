<?php

class Admin_PagesController extends Zend_Controller_Action
{

    /**
     *
     * @var type 
     */
    protected $_model;

    public function init()
    {
        $this->_helper->authentication->checkAuthentication(true);
         $this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js', $type = 'text/javascript', $attrs = array());
        $this->_model = new Model_Page();
    }

    /**
     * 
     */
    public function indexAction()
    {
        
        $criteria = array();

        $paginator = new Zend_Paginator(
                new App_Paginator_Adapter_Doctrine($this->_model->getAll($criteria)));
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $paginator->setItemCountPerPage(Model_Page::PER_PAGE);

        $this->view->pageList = $paginator;
    }
    
    /**
     * 
     */
    public function createAction()
    {
        $form = new Admin_Form_Page();
        
        if ($this->_request->isPost()) {
            # adding the new entity after validating the input data
            $post = $this->_request->getPost();
            
            if ($form->isValid($post)) {
                $pageItem = $this->_model->create($form->getValues());

                if ($pageItem) {
                    $this->_helper->redirector('index');
                }
            }
        }

        $this->view->form = $form;
    }  
    
    /**
     * 
     */
    public function updateAction()
    {
        # fetching the id and checks 
        $id = $this->_request->getParam('id', 0);
        if ($id == 0) {
            throw new InvalidArgumentException('Invalid request parameter: $id');
        }

        $pageItem = $this->_model->get($id);
        if ($pageItem == null) {
            throw new ItemNotFoundException('Page is not found in the database');
        }

        $form = new Admin_Form_Page();
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $dataValues = $form->getValues();

                $pageItem = $this->_model->update($dataValues, $id);
                if ($pageItem) {
                    $this->_helper->redirector('index');
                }
            }
        } else {
            $form->populate($pageItem->toArray());
        }

        $this->view->pageItem = $pageItem;
        $this->view->form = $form;
    }

    /**
     * 
     */
    public function deleteAction()
    {
        # fetching the id and checks 
        $id = $this->_request->getParam('id', 0);
        if (intval($id) == 0) {
            throw new InvalidArgumentException('Invalid request parameter: $id');
        }

        $pageItem = $this->_model->delete($id);
        if ($pageItem) {
            $this->_helper->redirector('index');
        }
    }    
    
    
    
}