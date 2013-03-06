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
     * User types
     */
    const ACTIVE_USER = 1;
    const INACTIVE_USER = 0;

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

        $rolesEntities = $this->getRepository('Entity_Roles')->findAll();
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

        return $this->getRepository('Entity_Roles')->find($roleId);
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

        return $this->getRepository('Entity_Roles')->findOneByName($roleName);
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

        $roleItem = $this->getRepository('Entity_Roles')->findOneByName($roleName);
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

    public function deactivateUser($id)
    {
        $userItem = $this->get($id);

        if ($userItem) {
            return $this->getRepository()->deactivateUser($userItem->getId());
        }

        return false;
    }

    public function activateUser($id)
    {
        $userItem = $this->get($id);

        if ($userItem) {
            return $this->getRepository()->activateUser($userItem->getId());
        }

        return false;
    }

    /**
     *
     * @param array $criteria
     * @return \Entity_User|boolean 
     */
    public function getUser(array $criteria = array())
    {
        $entity = $this->getRepository()->findOneBy($criteria);
        if ($entity && $entity instanceof Entity_Users) {
            return $entity;
        } else {
            return false;
        }
    }

    /**
     *
     * @param type $options
     * @return boolean 
     */
    public function rateForUser($params = array())
    {
        if (empty($params)) {
            throw new InvalidArgumentException('invalid parameter $options');
        }

        return $this->_em->getRepository('Entity_UserRatings')->createOrUpdate($params + array('commenter_id' => Service_Auth::getId()));
        return true;
    }

    /**
     *
     * @param type $options
     * @param type $user_id
     * @return type 
     */
    public function updateWallet($options, $user_id)
    {
        return $this->_em->getRepository('Entity_Wallets')->update($options + array('user' => $user_id));
    }

    /**
     *
     * @param type $userEntity
     * @return array 
     */
    public function getRatingsAsArray($userEntity)
    {
        $return = array();
        $ratings = $userEntity->getRatings();
        foreach ($ratings as $value) {
            array_push($return, $value);
        }
        return $return;
    }

    /*
     * 
     */

    public function getUserOpts()
    {
        $returnOptsArray = array();

        $entities = $this->getRepository()->findAll();
        foreach ($entities as $entity) {
            $returnOptsArray[$entity->getId()] = $entity->getUsername();
        }

        return $returnOptsArray;
    }

}