<?php

class Model_LoanComment extends Model_Abstract
{

    /**
     * Define entityName based on model
     * @var string
     */
    protected $_entityName = 'Entity_LoanComments';

    /**
     * Create comment by specific params
     *
     * @param array $params
     * @return Entity_LoanComments
     */
    public function create(array $params)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid argument: params');
        }

        return $this->getRepository()->createOrUpdate($params, null);
    }

    /**
     * Update comment by specific params
     *
     * @param array $params
     * @param integer $investmnetId
     * @return Entity_LoanComments
     */
    public function update(array $params, $commentId)
    {
        if (empty($params) || intval($commentId) == 0) {
            throw new InvalidArgumentException('Invalid arguments');
        }
        
        return $this->getRepository()->createOrUpdate($params, $commentId);
    }
    
    /**
     *
     * @param array $criteria
     * @return \Entity_LoanComments|boolean 
     */
    public function getComment(array $criteria = array()) {
        $entity = $this->getRepository()->findOneBy($criteria);
        if ($entity && $entity instanceof Entity_LoanComments) {
            return $entity;
        } else {
            return false;
        }
    }


}