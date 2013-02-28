<?php

class Model_Loan extends Model_Abstract
{

    const HOME_IMPROVEMENT = "Home improvement";
    const DEBT_CONSOLIDATION = "Debt consolidation";
    const BUSINESS = "Business";
    const MEDICAL_EXPENSES = "Medical expenses";
    const OTHER = "other";
    const STATUS_INPROGRESS = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_REPAIED = 3;
    const STATUS_CANCELED = 4;

    /**
     *
     * @var type 
     */
    public static $_purposesOpts = array(
        1 => self::HOME_IMPROVEMENT,
        2 => self::DEBT_CONSOLIDATION,
        3 => self::BUSINESS,
        4 => self::MEDICAL_EXPENSES,
        5 => self::OTHER
    );

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


        return $this->getRepository()->createOrUpdate($params + array('status' => self::STATUS_ACTIVE), null);
    }

    /**
     * Update loan by specific params
     *
     * @param array $params
     * @param integer $walletId
     * @return Entity_Wallets
     */
    public function update(array $params, $loanId)
    {
        if (empty($params) || intval($loanId) == 0) {
            throw new InvalidArgumentException('Invalid arguments');
        }

        return $this->getRepository()->createOrUpdate($params, $loanId);
    }

    /**
     *
     * @param array $criteria
     * @return \Entity_Loans|boolean 
     */
    public function getLoan(array $criteria = array())
    {
        $entity = $this->getRepository()->findOneBy($criteria);
        if ($entity && $entity instanceof Entity_Loans) {
            return $entity;
        } else {
            return false;
        }
    }

    public static function getInvestmentsAmount($investments, $flag = false)
    {
        $amount = 0;
        $percent = 0;
        if (!empty($investments)) {
            foreach ($investments as $investment) {
                $amount+=$investment->getAmount();
                $loan = $investment->getLoan();
            }
            if (!empty($investment)) {
                $percent = round(($amount / $investment->getLoan()->getAmount()) * 100);
            }
        }
        if (!$flag) {
            return $amount;
        } else {
            return $percent;
        }
    }

    public function finalizeLoan($loanId)
    {
        $this->getRepository()->finalizeLoan($loanId);
                
    }

}