<?php

/**
 * A template based email system
 */
class App_Mail
{

    protected $_mail;

    public function __construct()
    {
        $this->_mail = new Zend_Mail();
    }

    public function setSubject($subject)
    {
        if ($subject instanceof App_Mail_Template_Abstract) {
            $subject = $subject->build();
            $this->_mail->setSubject($subject);
        } else {
            $this->_mail->setSubject($subject);
        }
    }

    public function getSubject()
    {
        return $this->_mail->getSubject();
    }

    public function setBodyHtml($body)
    {
        if ($body instanceof App_Mail_Template_Abstract) {
            $body = $body->build();
            $this->_mail->setBodyHtml($body);
        } else {
            $this->_mail->setBodyHtml($body);
        }
    }

    public function getBodyHtml()
    {
        return $this->_mail->getBodyHtml();
    }

    public function addRecipient($email, $name = '')
    {
        $this->_mail->addTo($email, $name);
    }

    public function setSender($email, $name = '')
    {
        $this->_mail->setFrom($email, $name);
    }

    public function send()
    {
        $config = Zend_Registry::get('config');
        $auth = array(
            'auth' => 'login',
            'username' => $config->mail->username,
            'password' => $config->mail->password
        );

        $mailTransport = new Zend_Mail_Transport_Smtp($config->mail->server, $auth);
        Zend_Mail::setDefaultTransport($mailTransport);
        return $this->_mail->send();
    }

}