<?php

class Model_Payment extends Model_Abstract
{

    /**
     * Define entityName based on model
     * @var string
     */
    protected $_entityName = 'Entity_Payment';

    /**
     * Create wallet by specific params
     *
     * @param array $params
     * @return Entity_Wallets
     */
    public function create(array $params)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid argument: params');
        }

        return $this->getRepository()->createOrUpdate($params, null);
    }

    /**
     * Update wallet by specific params
     *
     * @param array $params
     * @param integer $walletId
     * @return Entity_Wallets
     */
    public function update(array $params, $walletId)
    {
        if (empty($params) || intval($walletId) == 0) {
            throw new InvalidArgumentException('Invalid arguments');
        }
        
        return $this->getRepository()->createOrUpdate($params, $walletId);
    }
    
    /**
     *
     * @param array $criteria
     * @return \Entity_Payment|boolean 
     */
    public function getPayment(array $criteria = array()) {
        $entity = $this->getRepository()->findOneBy($criteria);
        if ($entity && $entity instanceof Entity_Payment) {
            return $entity;
        } else {
            return false;
        }
    }


}