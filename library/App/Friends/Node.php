<?php
/**
 * 
 */

class App_Friends_Node
{
   
    protected $_connectedNodes = array();
    
    protected $_id = null; 
    
    public function __construct($id)
    {
        $this->setId($id);
    }
    
    
    public function setId($id)
    {
        $this->_id = $id;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    /**
     *
     * @param type $userId
     * @return boolean 
     */
    public function connectedTo($userId)
    {
        foreach($this->_connectedNodes as $node) {
            if ($node->getId() == $userId) {
                return true;
            }
        }
        return false;
    }
    /**
     *
     * @param type $node 
     */
    public function addConnectedNode($node)
    {
        $this->_connectedNodes[] = $node;
    }
    
    /**
     *
     * @return type 
     */
    public function getConnectedNodes()
    {
        return $this->_connectedNodes;
    }
}