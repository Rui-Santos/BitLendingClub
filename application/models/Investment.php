<?php

class Model_Investment extends Model_Abstract
{

    /**
     * Define entityName based on model
     * @var string
     */
    protected $_entityName = 'Entity_Investments';

    /**
     * Create wallet by specific params
     *
     * @param array $params
     * @return Entity_Investments
     */
    public function create(array $params)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid argument: params');
        }


        $investId = Service_Bitcoind::getInstance()->moveTo(Service_Bitcoind::getBitcoindAccount($params['user_id']), Service_Bitcoind::getBitcoindLoanAccount($params['loan_id']), (float) $params['amount']);

        if (!$investId) {
            throw new InvalidArgumentException('Transaction investment error');
        }
        Service_Bitcoind::getInstance()->sync(array('balance', 'address'), Service_Auth::getId());
        return $this->getRepository()->createOrUpdate($params, null);
    }

    /**
     * Update investment by specific params
     *
     * @param array $params
     * @param integer $investmnetId
     * @return Entity_Investments
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
     * @return \Entity_Investments|boolean 
     */
    public function getInvestment(array $criteria = array())
    {
        $entity = $this->getRepository()->findOneBy($criteria);
        if ($entity && $entity instanceof Entity_Investments) {
            return $entity;
        } else {
            return false;
        }
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

        $investment = $this->getRepository()->find($id);
        
        Service_Bitcoind::getInstance()->moveTo(Service_Bitcoind::getBitcoindLoanAccount($investment->getLoan()->getId()), Service_Bitcoind::getBitcoindAccount($investment->getInvestor()->getId()), $investment->getAmount());
        Service_Bitcoind::getInstance()->sync(array('balance', 'address'), Service_Auth::getId());
        
        return $this->getRepository()->delete($id);
    }

}