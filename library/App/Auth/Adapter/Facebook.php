<?php

class App_Auth_Adapter_Facebook implements Zend_Auth_Adapter_Interface
{

    const FACEBOOK_GRAPH_URL = 'https://graph.facebook.com/';
    
    private $_token = null;

    public function __construct($token)
    {
        $this->_token = $token;
    }

    public function authenticate()
    {
        if ($this->_token == null) {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, false, 
                    array('Token was not set'));
        }

        $userGraphUrl = self::FACEBOOK_GRAPH_URL . "me?access_token={$this->_token}";        
        $facebookUserDetails = json_decode(file_get_contents($userGraphUrl));
        
        if ($facebookUserDetails) {
            $userModel = new Model_User();
            $userItem = $userModel->getUserByEmail($facebookUserDetails->email);

            if ($userItem) {            
               
                // Update Facebook Facebook ID
                $userModel->updateFacebookUserId($facebookUserDetails->id, $userItem->getId());
            } else {
                $params = array(
                    'email' => $facebookUserDetails->email,
                    'firstname' => $facebookUserDetails->first_name,
                    'lastname' => $facebookUserDetails->last_name,
                    'fb_user_id' => $facebookUserDetails->id,
                    'is_email_confirmed' => Model_User::CONFIRMED,
                    'is_agree_terms_conditions' => Model_User::AGREE_TERMS_CONDITIONS,
                    'is_active' => Model_User::ACTIVE_USER,
                    'login_count' => 1,
                );
                
                $userItem = $userModel->create($params);
            }

            $userItem = $userModel->get($userItem->getId());
            $authResult = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, new Entity_Proxy_Users($userItem));
			
            return $authResult;
        } else {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, false, 
                    array('Invalid token passed as parameter'));            
        }
    }

}