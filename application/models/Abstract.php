<?php

abstract class Model_Abstract
{

    const PER_PAGE = 10;

    /**
     *
     * @var type 
     */
    protected $_repository;

    /**
     *
     * @var type 
     */
    protected $_entityName;

    /**
     *
     * @var type 
     */
    protected $_em;

    /**
     * 
     */
    public function __construct()
    {
        
        try {

            $this->_em = Zend_Registry::get('em');
        } catch (Exception $exc) {
            throw new EntityManagerNotFoundException($exc->getMessage());
        }
        
        if (!$this->_em || !($this->_em instanceof Doctrine\ORM\EntityManager)) {
            throw new EntityManagerNotFoundException('No entity Manager found');
        }

        $this->_repository = $this->_em->getRepository($this->_entityName);
    }

    /**
     *
     * @return type 
     */
    public function getRepository($entityClass = null)
    {
        if ($entityClass != null) {
            return $this->_em->getRepository($entityClass);
        }
        return $this->_repository;
    }

    /**
     * Get object by id
     * 
     * @param integer $id
     * @return Entity|NULL 
     */
    public function get($id)
    {
        if (intval($id) == 0) {
            throw new InvalidArgumentException('Invalid argument: id');
        }

        return $this->getRepository()->find($id);
    }

    /**
     * Get all objects
     * 
     * @param array $criteria
     * @return QueryBuilder
     */
    public function getAll(array $criteria = array(), $order = array())
    {
        return $this->getRepository()->getAll($criteria, $order);
    }
    
    /**
     *
     * @return type 
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }
    /**
     * Delete object by id
     * @param integer $id 
     * @return Entity
     */
    public function delete($id)
    {
        if (intval($id) == 0) {
            throw new InvalidArgumentException('Invalid argument: id');
        }

        return $this->getRepository()->delete($id);
    }

}
