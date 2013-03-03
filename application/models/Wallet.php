<?php

class Model_Wallet extends Model_Abstract
{

    /**
     * Define entityName based on model
     * @var string
     */
    protected $_entityName = 'Entity_Wallets';

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
        $params['balance'] = Service_Bitcoind::getInstance()->getBalance($params['user_id']);
        $params['address'] = Service_Bitcoind::getInstance()->getAccountAddress($params['user_id']);
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
     * @return \Entity_Wallet|boolean 
     */
    public function getWallet(array $criteria = array()) {
        $entity = $this->getRepository()->findOneBy($criteria);
        if ($entity && $entity instanceof Entity_Wallets) {
            return $entity;
        } else {
            return false;
        }
    }


}