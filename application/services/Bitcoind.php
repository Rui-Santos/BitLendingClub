<?php

/**
 * 
 */
class Service_Bitcoind extends Zend_Service_Abstract
{

    const ACCOUNT_CONST = "account";

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


        if (self::$_em == null) {
            self::$_em = Zend_Registry::get('em');
        }
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
    public function setJsonRcpClient($client)
    {
        if ($this->_jsonRpcClient == null) {
            $this->_jsonRpcClient = $client;
        }
        return $this;
    }

    /**
     *
     * @return type 
     */
    public function getJsonRcpClient()
    {
        return $this->_jsonRpcClient;
    }

    public function sync($options)
    {
        return $this->_configRcpClient()
                        ->_syncBalance($options)
                        ->_syncAddress($options);
    }

    protected function _configRcpClient()
    {
        // setting json rcp client with our bitcoind server
        $config = Zend_Registry::get('config');
        return $this->setJsonRpcClient(new App_jsonRPCClient('http://' . $config->btc->conn->user . ':' . $config->btc->conn->password . '@' . $config->btc->conn->url . '/'));
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


        $address = $this->getJsonRcpClient()->getaccountaddress(self::getBitcoindAccount($options['user_id']));
        $userModel = new Model_User();
        $userModel->updateWallet(array('address' => $address), $options['user_id']);
        return $this;
    }

    /**
     *
     * @param type $options
     * @throws InvalidArgumentException 
     */
    protected function _syncBalance($options)
    {
        if (!is_array($options)) {
            throw new InvalidArgumentException('invalid parameter $options');
        }

        // setting json rcp client with our bitcoind server


        $balance = $this->getJsonRcpClient()->getbalance(self::getBitcoindAccount($options['user_id']));
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
        $this->_configRcpClient();
        $fromAccount = self::getBitcoindAccount($user_id);
        try {
            $transactionId = $this->getJsonRcpClient()->sendfrom($fromAccount, $toAddress, $ammount);
        } catch (Exception $e) {
            throw new BitcoinServiceException($e->getMessage());
        }
        return $transactionId;
    }

}