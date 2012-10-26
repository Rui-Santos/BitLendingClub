<?php

/**
 * Transaction Manager for all kind of user process managment, 
 * payment functionality and custom transaction types
 */
class App_TransactionManager
{    
    const SEPARATOR_CLASSNAME = "_";

    protected static $_transactionSuffixes = array (
        Model_Transactions_BoughtDeal::ID => 'BoughtDeal',
        Model_Transactions_GiftDeal::ID => 'GiftDeal',
        Model_Transactions_GiftCard::ID => 'GiftCard',
        Model_Transactions_ReferralAmountReceived::ID => 'ReferralAmountReceived',
        Model_Transactions_RefundFailedDeal::ID => 'RefundFailedDeal',
        Model_Transactions_RefundFailedGift::ID => 'RefundFailedGift',
        Model_Transactions_DealAmountReceived::ID => 'DealAmountReceived',
        Model_Transactions_CanceledDeal::ID => 'CanceledDeal',
        Model_Transactions_CanceledDealGift::ID => 'CanceledDealGift',
        Model_Transactions_AdminAddFundToWallet::ID => 'AdminAddFundToWallet',
        Model_Transactions_AdminDeductFundFromWallet::ID => 'AdminDeductFundFromWallet',
        Model_Transactions_AffiliateBoughtDeal::ID => 'AffiliateBoughtDeal',
        Model_Transactions_DeductAmountFromUser::ID => 'DeductAmountFromUser',
    );
    
    private function __construct()
    {
    }
    
    /**
     * Create new transaction based on transaction type
     *
     * @param integer $type
     * @param array $params 
     * @return Model_Transactions_Abstract
     */
    public static function createTransaction($type, $params = array ())
    {
        if (!in_array($type, array_keys(self::$_transactionSuffixes))) {
            throw new InvalidArgumentException('Invalid transaction type');
        }
        
        $className = join(self::SEPARATOR_CLASSNAME, array('Model_Transactions', self::$_transactionSuffixes[$type]));
        if (!class_exists($className)) {
            throw new InvalidArgumentException('Unsupported transaction type');
        }        
        
        $obj = new $className($params);
        return $obj->create();                        
    }
}
