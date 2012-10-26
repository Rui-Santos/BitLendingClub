<?php

/**
 * Implementation of Friendship Graph
 */
class App_Friends_Graph
{

    /**
     *
     * @var type 
     */
    protected $_model = null;

    /**
     *
     * @var type 
     */
    protected $_nodes = array();

    /**
     *
     * @var type 
     */
    protected $_links = array();

    public function __construct()
    {
        $this->_model = new Model_User();
        $users = $this->_model->findAll();
        foreach ($users as $user) {
            $node = $this->addNode($user->getId());
        }

        $nodes = $this->getNodes();

        foreach ($nodes as $node) {
            $user = $this->_model->get($node->getId());
            if ($user->getFriends()) {
                $friends = $user->getFriends();
                foreach ($friends as $friend) {
                    $this->addLink($node, $this->getNode($friend->getUserB()->getId()));
                    $node->addConnectedNode($this->getNode($friend->getUserB()->getId()));
                }
            }
        }
    }

    /**
     *
     * @param type $id
     * @return \App_Friends_Node 
     */
    public function addNode($id)
    {
//        Zend_Debug::dump('adding node');
        $node = new App_Friends_Node($id);
        array_push($this->_nodes, $node);

        return $node;
    }

    /**
     *
     * @return type 
     */
    public function getNodes()
    {
        return $this->_nodes;
    }

    /**
     *
     * @param type $userId
     * @return boolean 
     */
    public function getNode($userId)
    {
        foreach ($this->_nodes as $node) {
            if ($node->getId() == $userId) {
                return $node;
            }
        }
        return false;
    }

    /**
     *
     * @param type $userA
     * @param type $userB
     * @return \App_Friends_Link 
     */
    public function addLink($userA, $userB)
    {
        $link = new App_Friends_Link($userA, $userB);
        array_push($this->_links, $link);
        return $link;
    }

    /**
     * 
     */
    public function save()
    {
        
    }

    /**
     * 
     */
    public function refresh()
    {
        
    }

}