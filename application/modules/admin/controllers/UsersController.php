<?php

class Admin_UsersController extends Zend_Controller_Action
{

    /**
     *
     * @var type
     */
    protected $_model;

    /**
     *
     * @var type
     */
    protected $_page = Model_Abstract::PER_PAGE;

    public function init()
    {
        $this->_helper->authentication->checkAuthentication(false);
        $this->_model = new Model_User();
        $this->view->headScript()->appendFile('/js/tiny_mce/tiny_mce.js', $type = 'text/javascript', $attrs = array());
    }

    public function indexAction()
    {
        $user = new Model_User();
        $user = $user->getUser(array('id' => Service_Auth::getLoggedUser()->getId()));
        
        
        if($user->getIsAdmin()) {
        $paginator = new Zend_Paginator(
                new App_Paginator_Adapter_Doctrine($this->_model->getAll()));
        } else {
            $paginator = new Zend_Paginator(
                new App_Paginator_Adapter_Doctrine($this->_model->getAll(array('id' =>$user->getId()))));
        }
        $paginator->setCurrentPageNumber($this->_getParam('page'));

        $paginator->setItemCountPerPage(Model_Abstract::PER_PAGE);
        $this->view->userList = $paginator;
        
        $this->view->user = $user;
    }

    /**
     *
     */
    public function createAction()
    {
        $tdModel = new Model_Td();
        $form = new Admin_Form_User(array(
                'titlesOpts' => Model_User::$titles,
                'tdOpts' => $tdModel->getFormOpts(),
//            'rolesOpts' => $this->_model->getRoleOpts(),
            ));


        if ($this->_request->isPost()) {
            # adding the new entity after validating the input data
            $post = $this->_request->getPost();
            if ($form->isValid($post)) {
                $userItem = $this->_model->create($form->getValues());

                if ($userItem) {
                    $this->_helper->redirector('index');
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     *
     * @throws InvalidArgumentException 
     */
    public function updateAction()
    {
        # fetching the id and checks 
        $id = $this->_request->getParam('id', 0);
        if ($id == 0) {
            throw new InvalidArgumentException('Invalid request parameter: $id');
        }
        $tdModel = new Model_Td();
        $form = new Admin_Form_User(array(
                'titlesOpts' => Model_User::$titles,
                'tdOpts' => $tdModel->getFormOpts(),
//            'rolesOpts' => $this->_model->getRoleOpts(),
            ));

        $userItem = $this->_model->get($id);
        $form->populate($userItem->toArray());

        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            
            if ($form->isValid($post)) {
                $userItem = $this->_model->update($form->getValues(), $id);

                if ($userItem) {
                    $this->_helper->redirector('index');
                }
            }
        }

        $this->view->assign(array('form' => $form, 'id' => $id));
    }

    /**
     *
     * @throws InvalidArgumentException 
     */
    public function deleteAction()
    {
        # fetching the id and checks 
        $id = $this->_request->getParam('id', 0);
        if (intval($id) == 0) {
            throw new InvalidArgumentException('Invalid request parameter: $id');
        }

        $dealItem = $this->_model->delete($id);
        if ($dealItem) {
            $this->_helper->redirector('index');
        }
    }

}