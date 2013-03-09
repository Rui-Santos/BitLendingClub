<?php

/**
 * 
 */
class Service_Bitcoind extends Service_Bitcoind_Abstract
{

    const ACCOUNT_CONST = "account";
    const LOAN_CONST = "loan";
    const BLC_USERID = 0;

    /**
     *
     * @var type 
     */
    protected $_user = null;

    /**
     *
     * @var type 
     */
    protected $_pass = null;

    /**
     *
     * @var type 
     */
    protected static $_instance;

    /**
     *
     * @var type 
     */
    protected $_jsonRpcClient = null;

    protected function __construct()
    {
        return;
    }

    public static function getInstance()
    {

        if (self::$_instance == null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     *
     * @param type $client
     * @return \Service_Bitcoind 
     */
    public function setJsonRpcClient($client)
    {

        $this->_jsonRpcClient = $client;
        return $this;
    }

    /**
     *
     * @return type 
     */
    public function getJsonRpcClient()
    {
        return $this->_jsonRpcClient;
    }

    /**
     * 
     * @param type $options options like array('user_id' => $value);
     * @return type
     * @throws BitcoinServiceException
     */
    public function sync($syncingOpts, $user_id)
    {
       
        if (!is_array($syncingOpts)) {
            throw new InvalidArgumentException('invalid parameter $syncingopts');
        }
        $this->_configRpcClient();
        while ($syncingOpts) {
            $opt = array_shift($syncingOpts);
            call_user_func(array($this, join('', array("_sync", ucfirst($opt)))), array('user_id' => $user_id));
        }
    }

    /**
     * 
     * @return \Service_Bitcoind
     */
    protected function _configRpcClient()
    {

        if ($this->getJsonRpcClient() !== null) {
            return $this;
        }
        // setting json rcp client with our bitcoind server
        $config = Zend_Registry::get('config');
        $this->_user = $config->btc->conn->user;
        $this->_pass = $config->btc->conn->pass;
        return $this->setJsonRpcClient(new App_jsonRPCClient('http://' . $this->_user . ':' . $this->_pass . '@' . $config->btc->conn->host . '/'));
    }

    /**
     *
     * @param type $options
     * @throws InvalidArgumentException 
     */
    protected function _syncAddress($options)
    {
        if (!is_array($options)) {
            throw new InvalidArgumentException('invalid parameter $options');
        }

        $address = $this->getJsonRpcClient()->getaccountaddress(self::getBitcoindAccount($options['user_id']));
        $userModel = new Model_User();
        $userModel->updateWallet(array('walletPath' => $address), $options['user_id']);
        return $this;
    }

    /**
     *
     * @param type $options
     * @throws InvalidArgumentException 
     */
    public function _syncBalance($options)
    {
        if (!is_array($options)) {
            throw new InvalidArgumentException('invalid parameter $options');
        }

        // setting json rcp client with our bitcoind server
        $balance = $this->getJsonRpcClient()->getbalance(self::getBitcoindAccount($options['user_id']));

        $userModel = new Model_User();
        $userModel->updateWallet(array('balance' => $balance), $options['user_id']);
        return $this;
    }

    /**
     *
     * @param type $user_id
     * @return type
     * @throws InvalidArgumentException 
     */
    public static function getBitcoindAccount($user_id)
    {
        if (!is_numeric($user_id)) {
            throw new InvalidArgumentException('invalid argument $user_id');
        }
        return join('_', array(self::ACCOUNT_CONST, $user_id));
    }
    
    /**
     *
     * @param type $user_id
     * @return type
     * @throws InvalidArgumentException 
     */
    public static function getBitcoindLoanAccount($loan_id)
    {
        if (!is_numeric($loan_id)) {
            throw new InvalidArgumentException('invalid argument $loan_id');
        }
        return join('_', array(self::LOAN_CONST, $loan_id));
    }

    /**
     * 
     * @param type $user_id
     * @return type
     * @throws BitcoinServiceException
     */
    public function getAccountAddress($user_id)
    {
        $this->_configRpcClient();
        try {
            $address = $this->getJsonRpcClient()->getaccountaddress(self::getBitcoindAccount($user_id));
        } catch (Exception $e) {
            throw new BitcoinServiceException($e->getMessage());
        }
        return $address;
    }
    
    /**
     * 
     * @param type $loan_id
     * @return type
     * @throws BitcoinServiceException
     */
    public function getLoanAddress($loan_id)
    {
        $this->_configRpcClient();
        try {
            $address = $this->getJsonRpcClient()->getaccountaddress(self::getBitcoindLoanAccount($loan_id));
        } catch (Exception $e) {
            throw new BitcoinServiceException($e->getMessage());
        }
        return $address;
    }

    /**
     * 
     * @param type $user_id
     * @return type
     * @throws BitcoinServiceException
     */
    public function getBalance($user_id)
    {
        $this->_configRpcClient();
        try {
            $balance = $this->getJsonRpcClient()->getbalance(self::getBitcoindAccount($user_id));
        } catch (Exception $e) {
            throw new BitcoinServiceException($e->getMessage());
        }
        return $balance;
    }

    /**
     * 
     * @param type $toAddress
     * @param type $ammount
     * @param type $userId
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function sendPayment($toAddress, $ammount, $userId)
    {
       
        if ($toAddress == null || $toAddress == "") {
            throw new BitcoinServiceException("Invalid Argument toAddress");
        }
        if (!is_numeric($ammount)) {
            throw new BitcoinServiceException('invalid argument ammount');
        }
        if ($ammount == 0) {
            return false;
        }
        $this->_configRpcClient();
        try {
            $this->getJsonRpcClient()->walletpassphrase($this->_pass, 2000);
            $transactionId = $this->getJsonRpcClient()->sendfrom(self::getBitcoindAccount($userId), $toAddress, $ammount);
        } catch (Exception $e) {
            throw new BitcoinServiceException($e->getMessage());
        }
        return $transactionId;
    }

    /**
     * 
     * @param type $ammount
     * @param type $userId
     * @return boolean
     * @throws BitcoinServiceException
     */
    public function sendPaymentToBlc($ammount, $userId)
    {
        if (!is_numeric($ammount)) {
            throw new BitcoinServiceException('invalid argument ammount');
        }
        if ($ammount == 0) {
            return false;
        }

        $this->_configRpcClient();
        try {
            // getting btc address
            $toAddress = $this->getJsonRpcClient()->getaccountaddress(self::getBitcoindAccount(self::BLC_USERID));
            $this->getJsonRpcClient()->walletpassphrase($this->_pass, 2000);
            $transactionId = $this->getJsonRpcClient()->sendfrom(self::getBitcoindAccount($userId), $toAddress, $ammount);
        } catch (Exception $e) {
            throw new BitcoinServiceException($e->getMessage());
        }
        return $transactionId;
    }

    /**
     * 
     * @param type $adressesAmmountsPairs
     * @param type $userId
     * @return type
     */
    public function sendPayments($adressesAmmountsPairs, $userId)
    {

        return $transactionId;
    }

}