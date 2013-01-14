<?php

class Model_Loan extends Model_Abstract
{

    /**
     * Define entityName based on model
     * @var string
     */
    protected $_entityName = 'Entity_Loans';

    /**
     * Create wallet by specific params
     *
     * @param array $params
     * @return Entity_Loans
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
     * @return \Entity_Loans|boolean 
     */
    public function getLoan(array $criteria = array()) {
        $entity = $this->getRepository()->findOneBy($criteria);
        if ($entity && $entity instanceof Entity_Loans) {
            return $entity;
        } else {
            return false;
        }
    }


}