<?php

class Model_User extends Model_Abstract
{

    /**
     * Role types
     */
    const ADMIN_ROLE = 'admin';
    const REGULAR_ROLE = 'regular';
    const COMPANY_ROLE = 'company';
    const RESELLER_ROLE = 'reseller';

    /**
     * Reset password length
     */
    const RESET_PASSWORD_LENGTH = 8;

    /**
     * User types
     */
    const ACTIVE_USER = 1;
    const INACTIVE_USER = 0;
    const AGREE_TERMS_CONDITIONS = 1;

    /**
     * Define entityName based on model
     * @var string
     */
    protected $_entityName = 'Entity_Users';

    /**
     * All types of transactions type id's that are added to total savings
     * @return arrau
     */
    public static $transactionTypesAddedToSavings = array(1, 2);

    /**
     * Get all roles as array
     *
     * @return arrau
     */
    public function getRoleOpts()
    {
        $roles = array();

        $rolesEntities = $this->getRepository('Entity_UserRoles')->findAll();
        foreach ($rolesEntities as $entity) {
            $roles[$entity->getId()] = $entity->getName();
        }

        return $roles;
    }

    /**
     * Get role by ID
     *
     * @param integer $roleId
     * @return Entity_UserRoles
     */
    public function getRole($roleId)
    {
        if (intval($roleId) == 0) {
            throw new InvalidArgumentException('Invalid parameter $roleId');
        }

        return $this->getRepository('Entity_UserRoles')->find($roleId);
    }

    /**
     * Get role by name
     *
     * @param string $roleName
     * @return Entity_UserRoles
     */
    public function getRoleByName($roleName)
    {
        if (empty($roleName)) {
            throw new InvalidArgumentException('Invalid parameter $roleName');
        }

        return $this->getRepository('Entity_UserRoles')->findOneByName($roleName);
    }

    /**
     * Get role by name
     *
     * @param string $roleName
     * @return integer
     */
    public function getRoleIdByName($roleName)
    {
        if (empty($roleName)) {
            throw new InvalidArgumentException('Invalid parameter $roleName');
        }

        $roleItem = $this->getRepository('Entity_UserRoles')->findOneByName($roleName);
        return (int) $roleItem->getId();
    }

    /**
     * Get user by specific email
     *
     * @param string $email
     * @return Entity_Users
     */
    public function getUserByEmail($email)
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Invalid parameter $email');
        }

        return $this->getRepository('Entity_Users')->findOneByEmail($email);
    }

    /**
     * Create user by specific params (registration)
     *
     * @param array $params
     * @return Entity_Users
     */
    public function create(array $params)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid argument: params');
        }

        if (!isset($params['role_id'])) {
            $params['role_id'] = $this->getRoleIdByName(self::REGULAR_ROLE);
        }

        if (isset($params['password']) && !empty($params['password'])) {
            $params['password'] = md5($params['password']);
        } else if (isset($params['password'])) {
            unset($params['password']);
        }

        return $this->getRepository()->createOrUpdate($params, null);
    }

    /**
     * Update user by specific params
     *
     * @param array $params
     * @param integer $userId
     * @return Entity_Users
     */
    public function update(array $params, $userId)
    {
        if (empty($params) || intval($userId) == 0) {
            throw new InvalidArgumentException('Invalid arguments');
        }

        if (isset($params['avatar']) && !empty($params['avatar'])) {
            $this->removeAvatar($userId);
        }

        if (isset($params['password']) && !empty($params['password'])) {
            $params['password'] = md5($params['password']);
        } else if (isset($params['password'])) {
            unset($params['password']);
        }

        return $this->getRepository()->createOrUpdate($params, $userId);
    }

    /**
     * Remove avatar from user
     *
     * @param integer $userId
     * @return boolean
     */
    public function removeAvatar($userId)
    {
        $userItem = $this->get($userId);
        if ($userItem == null) {
            throw new ItemNotFoundException("Not find proper user item for $userId");
        }

        $config = Zend_Registry::get('config');

        if ($userItem) {
            $imageAbsolutePath = realpath($config->paths->user_image . $userItem->getAvatar());
            if (file_exists($imageAbsolutePath) && unlink($imageAbsolutePath)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Increment login count
     *
     * @param integer $userId
     * @return Entity_Users
     */
    public function incrementLoginCount($userId)
    {
        if (intval($userId) == 0) {
            throw new InvalidArgumentException('Invalid parameter $userId');
        }

        return $this->getRepository()->incrementLoginCount($userId);
    }

    /**
     * Authenticate user by email and password
     *
     * @param string $username
     * @param string $password
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function authenticate($email, $password)
    {

        if (empty($email) || empty($password)) {
            throw new InvalidArgumentException('Invalid username or password');
        }

        $entity = $this->getRepository()->findOneBy(array('email' => $email, 'password' => $password));
        if ($entity) {
            return $entity;
        }

        return false;
    }

    /**
     * Compare password with the current one
     *
     * @param string $passwd
     * @param integer $userId
     * @return boolean
     */
    public function passwdCompare($passwd, $userId)
    {
        if (intval($userId) == 0 || empty($passwd)) {
            throw new InvalidArgumentException('Invalid parameters');
        }

        $user = $this->get($userId);
        if (md5($passwd) == $user->getPassword()) {
            return true;
        }

        return false;
    }

    /**
     * Update current user password
     *
     * @param array $params
     * @param integer $userId
     * @return boolean
     */
    public function updatePassword($params, $userId)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid values array');
        }

        if (intval($userId) == 0) {
            throw new InvalidArgumentException('Invalid parameter $userId');
        }

        $params['password'] = md5($params['password']);

        return $this->getRepository()->updatePassword($params, $userId);
    }

    /**
     * Confirm registration (send mail with unique key)
     *
     * @param integer $userId
     * @return boolean
     */
    public function confirmRegistration($userId)
    {
        $config = Zend_Registry::get('config');

        $userItem = $this->get($userId);

        $confirmationKey = $this->generateConfirmationKey($userId);

        // Create confirmation template
        $bodyTemplate = new App_Mail_Template_ConfirmRegistration();
        $bodyTemplate->fullname = $userItem->getFullname();
        $bodyTemplate->link = "{$config->absoluteUrl}auth/confirm-registration/key/{$confirmationKey}";

        // Send confirmation mail
        $mail = new App_Mail();
        $mail->setSubject('Confirm registration from Gruper.mk');
        $mail->setBodyHtml($bodyTemplate);
        $mail->addRecipient($userItem->getEmail());
        $mail->setSender($config->mail->from);
        return $mail->send();
    }

    /**
     * Confirm forgotten password (send mail with unique key)
     *
     * @param integer $userId
     * @return boolean
     */
    public function confirmForgottenPassword($userId)
    {
        $config = Zend_Registry::get('config');

        $userItem = $this->get($userId);

        $confirmationKey = $this->generateConfirmationKey($userId);

        // Create confirmation template
        $bodyTemplate = new App_Mail_Template_ConfirmForgottenPassword();
        $bodyTemplate->fullname = $userItem->getFullname();
        $bodyTemplate->link = "{$config->absoluteUrl}auth/confirm-forgotten-password/key/{$confirmationKey}";

        // Send confirmation mail
        $mail = new App_Mail();
        $mail->setSubject('Confirm forgotten passwowrd from Gruper.mk');
        $mail->setBodyHtml($bodyTemplate);
        $mail->addRecipient($userItem->getEmail());
        $mail->setSender($config->mail->from);
        return $mail->send();
    }

    /**
     * Generate confirmation key for user
     *
     * @param integer $userId
     * @return string|null
     */
    public function generateConfirmationKey($userId)
    {
        $userItem = $this->getRepository()->find($userId);

        if ($userItem) {
            $confirmationKey = md5($userItem->getId() . $userItem->getEmail() . $userItem->getPassword() . time());
            $result = $this->getRepository()->setConfirmationKey($userId, $confirmationKey);
            if ($result) {
                return $confirmationKey;
            }
        }
    }

    /**
     * Set mail confirmed according confirmation key
     *
     * @param string $key
     * @return boolean
     */
    public function setMailConfirmed($key)
    {
        $userItem = $this->getRepository()->findOneBy(array('confirmationKey' => $key));

        if ($userItem) {
            return $this->getRepository()->setMailConfirmed($userItem->getId());
        }

        return false;
    }

    /**
     * Reset forgotten password according confirmation key
     *
     * @param string $key
     * @return boolean
     */
    public function resetForgottenPassword($key)
    {
        $config = Zend_Registry::get('config');

        $userItem = $this->getRepository()->findOneBy(array('confirmationKey' => $key));
        if ($userItem) {
            $resetPassword = $this->resetPassword($userItem->getId());

            // Create confirmation template
            $bodyTemplate = new App_Mail_Template_ResetForgottenPassword();
            $bodyTemplate->fullname = $userItem->getFullname();
            $bodyTemplate->password = $resetPassword;

            // Send confirmation mail
            $mail = new App_Mail();
            $mail->setSubject('Your temporary password from Gruper.mk');
            $mail->setBodyHtml($bodyTemplate);
            $mail->addRecipient($userItem->getEmail());
            $mail->setSender($config->mail->from);
            return $mail->send();
        }

        return false;
    }

    /**
     * Reset user password with temporary one
     *
     * @param integer $userId
     * @return stringe
     */
    public function resetPassword($userId)
    {
        // Generate radmon password
        $randomPassword = App_Helper_Util::generateRandomString(self::RESET_PASSWORD_LENGTH);

        // Update user password
        $params['password'] = md5($randomPassword);
        $this->getRepository()->updatePassword($params, $userId);

        return $randomPassword;
    }

    /**
     * Update Facebook User ID to specific user
     *
     * @param integer $fbUserId
     * @param integer $userId
     * @return boolean
     */
    public function updateFacebookUserId($fbUserId, $userId)
    {
        $result = $this->getRepository()->updateFacebookUserId($fbUserId, $userId);
        if ($result) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param type $token
     * @param type $tokenSecret
     * @param type $user_id
     * @return type
     * @throws InvalidArgumentException
     */
    public function updateTwitterTokens($token, $tokenSecret, $user_id)
    {
        if ($token == '' || $tokenSecret == '') {
            throw new InvalidArgumentException('invalid parameter $token or $tokenSecret when updating Twitter tokens');
        }
        if (intval($user_id) == 0) {
            throw new InvalidArgumentException('invalid parameter $user_id when updateing twitter tokens');
        }
        $params = array('twitterAccessToken' => $token, 'twitterAccessTokenSecret' => $tokenSecret);
        return $this->getRepository()->createOrUpdate($params, $user_id);
    }

    /**
     *
     *
     * @param array $params
     * @param type $user_id
     * @return boolean
     */
    public function updateSubscriptions(array $params, $user_id = null)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid parameter $params while updating user subscriptions ');
        }
        if (intval($user_id) == 0) {
            throw new InvalidArgumentException('Invalid parameter $user_id while updating user subscriptions');
        }
        $subscriptions = $this->getRepository('Entity_UserSubscriptions')->findOneBy(array('user' => $user_id));
        $subscriptionId = $subscriptions ? $subscriptions->getId() : null;
        $subscriptionId = $this->getRepository('Entity_UserSubscriptions')->createOrUpdate($params + array('user_id' => $user_id), $subscriptionId);
        if ($subscriptionId) {
            $this->getRepository('Entity_SubscriptionsCategories')->remove($subscriptionId);
            $this->getRepository('Entity_SubscriptionsCategories')->createOrUpdate($params, $subscriptionId);
            $this->getRepository('Entity_SubscriptionsCities')->remove($subscriptionId);
            $this->getRepository('Entity_SubscriptionsCities')->createOrUpdate($params, $subscriptionId);
        }
        return true;
    }

    /**
     *
     * @param type $userId
     * @return array
     */
    public function getSubscriptionsCatsOpts($userId)
    {
        $cats = array();
        $subscriptionEntity = $this->getRepository('Entity_UserSubscriptions')->findOneBy(array('user' => $userId));
        if ($subscriptionEntity) {
            $categories = $subscriptionEntity->getCategories();
            foreach ($categories as $value) {
                array_push($cats, $value->getCategory()->getId());
            }
        }

        return $cats;
    }

    /**
     *
     * @param type $userId
     * @return array
     */
    public function getSubscriptionsCitiesOpts($userId)
    {
        $citiesArr = array();
        $subscriptionEntity = $this->getRepository('Entity_UserSubscriptions')->findOneBy(array('user' => $userId));
        if ($subscriptionEntity) {
            $cities = $subscriptionEntity->getCities();
            foreach ($cities as $value) {
                array_push($citiesArr, $value->getCity()->getId());
            }
        }

        return $citiesArr;
    }

    /**
     *
     * @param type $userId
     * @return type
     * @throws InvalidArgumentException
     */
    public function getSubscription($userId)
    {
        if (intval($userId) == 0) {
            throw new InvalidArgumentException('invalid parameter $userId');
        }

        $subscriptionEntity = $this->getRepository('Entity_UserSubscriptions')->findOneBy(array('user' => $userId));
        return $subscriptionEntity;
    }

    /**
     *  returning the social type of the user (public by default)
     *
     * @param type $user_id
     * @param type $rule
     * @return type
     */
    public function getType($user_id, $rule)
    {
        $user = $this->get($user_id);
        $profileAccessSettings = $user->getProfileAccessSettings();
        foreach ($profileAccessSettings as $value) {
            if ($value->getRule()->getId() == $rule) {
                return $value->getType()->getId();
            }
        }
        return self::PUBLIC_AND_FRIEND;
    }

    /**
     *
     * @param type $userNodes
     * @return type
     */
    public function convertNodesToOpts($userNodes = array())
    {
        $opts = array();
        foreach ($userNodes as $node) {
            $userEntity = $this->get($node->getId());
            if ($userEntity) {
                $opts[$node->getId()] = $userEntity->getFullname();
            }
        }
        return $opts;
    }

    /**
     *
     * @return type
     */
    public function getFormOpts()
    {
        $opts = array();
        $users = $this->findAll();
        foreach ($users as $user) {
            $opts[$user->getId()] = $user->getFullname();
        }
        return $opts;
    }

    /**
     * Get user debit amount
     *
     * @return number
     */
    public function getUserDebitAmount($userId = null)
    {
        if (is_null($userId)) {
            $userId = Service_Auth::getId();
        }

        $debitAmount = 0.00;

        $userItem = $this->get($userId);
        if ($userItem) {
            $debitAmount = $userItem->getDebitAmount();
        }

        return $debitAmount;
    }

    public function getTotalSavings($userid = null)
    {
        $sum = 0;
        if (empty($userid))
            return 0;
        $user = $this->get($userid);
        if (!$user) {
            throw new InvalidArgumentException('invalid argument $userid');
        }
        foreach ($user->getTransactions() as $transaction) {
            if (in_array($transaction->getType()->getId(), Model_User::$transactionTypesAddedToSavings)) {
                foreach ($transaction->getItems() as $transactionItem) {
                    $deal = $transactionItem->getDeal();
                    $sum = $sum + $transactionItem->getQuantity() * ($deal->getPublicPrice() - $deal->getDiscountedPrice());
                }
            }
        }

        return $sum;
    }

}