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
    const BlcPercentage = 0.1;

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
    public static $_statuses = array(
        self::STATUS_ACTIVE => 'active',
        self::STATUS_INPROGRESS => 'in progress',
        self::STATUS_REPAIED => 'repaied',
        self::STATUS_CANCELED => 'canceled'
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
    /**
     * 
     * @param type $loanId
     */
    public function finalizeLoan($loanId)
    {
        $entity = $this->getRepository()->changeLoanStatus($loanId, self::STATUS_INPROGRESS);
        $this->getRepository()->updateStartDate($loanId);
        
        $investments = $entity->getInvestments();
        $paymentModel = new Model_Payment();
        $walletModel = new Model_Wallet();
        $userWallet = $walletModel->getWallet(array('user' => $entity->getBorrower()->getId()));


        foreach ($investments as $investment) {
            Service_Bitcoind::getInstance()->sendPayment($userWallet->getWalletPath(), $investment->getAmount(), $investment->getInvestor()->getId());

            $params = array('loan_id' => $loanId,
                'amount' => $investment->getAmount(),
                'type' => Model_Payment::TYPE_INVEST,
                'user_id' => $investment->getInvestor()->getId(),
                'address' => $userWallet->getWalletPath());

            $paymentModel->create($params);
        }
    }

    /**
     * 
     * @param type $loanId
     * @param type $status
     * @return boolean
     */
    public function changeStatus($loanId, $status)
    {
        return $this->getRepository()->changeLoanStatus($loanId, $status);
    }

    /**
     * 
     * @param type $loanId
     * @return boolean
     */
    public function checkRepaied($loanId)
    {
        if (!is_numeric($loanId)) {
            throw new InvalidArgumentException('invalid parameter $loanid');
        }

        $repaymentsCount = $this->calculateRepaymentsCount($loanId);
        $loan = $this->get($loanId);
        if ($loan->getPayments()->count() == $repaymentsCount) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $loanId
     * @return boolean
     */
    public function repay($loanId)
    {
        $paymentModel = new Model_Payment();

        // sending some money to the people and repay a payment for a loan  
        $loan = $this->get($loanId);
        $investments = $loan->getInvestments();
        foreach ($investments as $value) {
            $fee = $value->getAmmount() / $this->getRepaymentsCount($loanId);
            $percentile = ($fee * $value->getRate()) / 100;
            $fee += $percentile;

            $transactionId = Service_Bitcoind::getInstance()->sendPayment($value->getInvestor()->getWallet()->getWalletPath(), $fee, Service_Auth::getId());

            if ($transactionId) {

                $params = array(
                    'loan_id' => $loanId,
                    'amount' => $fee,
                    'type' => Model_Payment::TYPE_REPAY,
                    'user_id' => Service_Auth::getId(),
                    'address' => $value->getInvestor()->getWallet()->getWalletPath());
                $paymentModel->create($params);
            }
            // adding the btc's to the account to the server
        }
        //sending payment to blc (0.1 percentage)
        Service_Bitcoind::sendPaymentToBlc($this->getBlcTax($loanId), Service_Auth::getId());
        Service_Bitcoind::getInstance()->sync(array('user_id' => Service_Auth::getId()));

        $responseRepaied = $this->checkRepaied($loanId);
        if ($responseRepaied) {
            $this->changeStatus($loanId, self::STATUS_REPAIED);
        }
        return true;
    }

    /**
     * 
     * @param type $loanId
     * @return type
     */
    public function calculateRepaymentsCount($loanId)
    {
        $entity = $this->get($loanId);
        return round($entity->getTerm() / $entity->getFrequency);
    }

    /**
     * 
     * @param type $loanId
     * @return type
     */
    public function getBlcTax($loanId)
    {
        $loan = $this->get($loanId);

        $blcFee = $loan->getAmmount() / $loan->getFrequency();
        return ($blcFee * self::BlcPercentage) / 100;
    }

}