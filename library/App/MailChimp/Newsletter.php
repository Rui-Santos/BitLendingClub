<?php

/**
 * @author yayankov
 * 
 */
require "MCAPI.class.php";

class App_Mailchimp_Newsletter {
    
    /**
     *
     * @var type 
     */
    protected $_config = null;
    /**
     *
     * @var type 
     */
    protected $_api = null; 
    /**
     *
     * @var type 
     */
    protected $_digest = array ();
    /**
     *
     * @param type $options 
     */
    public function __construct($options = array())
    {
        if (isset($options['config'])) {
            $this->_config = $options['config'];
        } 
        $this->_api = new MCAPI($this->_config->mailchimp->api_key);
    }
    /**
     *
     * @return \App_Mailchimp_Newsletter 
     */
    public function build($digest = true)
    {
        if (!$digest) {
            throw new NewsletterException('currently we do not support any newsletter but digest. Set $digest parameter to true ');
        }
        
        $userModel = new Model_User();
        $users = $userModel->findAll();
        foreach ($users as $user) {
            if (count($user->getSubscriptions()) != 0) {
                $subscriptions = $user->getSubscriptions();
                
                $this->_digest = $this->_generate($subscriptions->current())
                                        ->_toHtml()
                                        ->sendMail($user);
                
                // unset $_digest variable
                $this->_tearDown();
            }
        }
        
        return $this;
    }
    /**
     *
     * returning data for digest in structure 
     * array($category_id => array ($deals), $category_id2 => array ($deals));
     * 
     * @param type $subscription
     * @return array
     */
    protected function _generate($subscription) 
    {
        $dealModel = new Model_Deal();
        $categories = $subscription->getCategories();
        
        foreach ($categories as $key => $value) {
            $this->_digest[$value->getCategory()->getName()] = $dealModel->findNewDeals(array('category' => $value->getCategory()->getId()), time(), Model_Deal::DAY_PERIOD);
        }
        
        return $this;
    }
    /**
     *
     * @return type 
     */
    protected function _toHtml()
    {
        $template = new App_Mail_Template_NewsletterDigest();
        $template->digest = $this->_digest;
        $template->url = Zend_Registry::get('config')->absoluteUrl;
        $this->_digest =  $template->build();
        return $this;
    }
    /**
     * 
     */
    public function sendMail($recipient)
    {
        $mail = new App_Mail();
        $mail->addRecipient($recipient->getEmail(), $recipient->getFullname());
        $mail->setSubject("Grouper.MK Newsletter - интересни сделки");
        $mail->setBodyHtml($this->_digest);
        $mail->setSender('office@grouper.mk');
//        return $mail->send();
        return true;
        
    }
    
    /**
     *
     * @return \App_Mailchimp_Newsletter 
     */
    protected function _tearDown()
    {
        $this->_digest = array();
        return $this;
        
    }
}