<?php
/**
 * 
 */
class App_Friends_Link
{
    
    protected $_userA;
    
    protected $_userB;
    
    public function __construct($userA, $userB)
    {
        if ($userA->getId() === $userB->getId()) {
            //throw new InvalidArgumentException('Cannot refer one and the same user as a friend of himself');
        }
        $this->_userA = $userA;
        
        $this->_userB = $userB;
    }
    
}