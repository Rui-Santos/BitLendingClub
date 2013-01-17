<?php

class Model_Page extends Model_Abstract
{

    /**
     *
     * @var Entity_Pages $_entityName 
     */
    protected $_entityName = "Entity_Pages";

    /**
     * Create new static page
     *
     * @param array $params
     * @return Entity_Pages 
     */
    public function create(array $params)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid argument: params');
        }

        return $this->getRepository()->createOrUpdate($params, null);
    }

    /**
     * Update static page
     *
     * @param array $params
     * @param integer $pageId
     * @return Entity_Pages 
     */
    public function update(array $params, $pageId)
    {
        if (empty($params) || intval($pageId) == 0) {
            throw new InvalidArgumentException('Invalid arguments');
        }

        return $this->getRepository()->createOrUpdate($params, $pageId);
    }

    
     public function getPage(array $criteria = array())
    {
        $entity = $this->getRepository()->findOneBy($criteria);
        if ($entity && $entity instanceof Entity_Pages) {
            return $entity;
        } else {
            return false;
        }
    }

}