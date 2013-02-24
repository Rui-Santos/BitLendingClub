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

    /**
     *
     * @param type $options
     * @throws InvalidArgumentException 
     */
    public function sync($options)
    {

        if (!is_array($options)) {
            throw new InvalidArgumentException('invalid parameter $options');
        }

        // setting json rcp client with our bitcoind server
        $config = Zend_Registry::get('config');
        $this->setJsonRpcClient(new App_jsonRPCClient('http://' . $config->bitcoind->user . ':' . $config->bitcoind->password . '@' . $config->bitcoind->url . '/'));


        $balance = $this->getJsonRcpClient()->getBalance(self::getBitcoindAccount($options['user']));
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

}