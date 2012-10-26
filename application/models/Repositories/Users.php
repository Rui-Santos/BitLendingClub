<?php

use Doctrine\ORM\EntityRepository;

class Repository_Users extends EntityRepository
{

    /**
     * Get all users
     * 
     * @param array $criteria
     * @return array 
     */
    public function getAll(array $criteria = array())
    {
        $query = $this->createQueryBuilder('deals');

        if (!empty($criteria)) {
            $i = 0;
            foreach ($criteria as $key => $value) {
                if ($i == 0) {
                    $query->where("deals.{$key} = :{$key}");
                    $query->setParameter($key, $value);
                } else {
                    $query->andWhere("deals.{$key} = :{$key}");
                    $query->setParameter($key, $value);
                }

                $i++;
            }
        }

        return $query;
    }

    /**
     * Delete user by id
     * 
     * @param integer $id
     * @return Entity_Users 
     */
    public function delete($id)
    {
        $entity = $this->find($id);

        if ($entity) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }

        return $entity;
    }

    /**
     * Create or update user record
     * 
     * @param array $params
     * @param integer $id
     * @return Entity_Users 
     */
    public function createOrUpdate(array $params, $id = null)
    {
        if (is_null($id)) {
            $entityName = $this->getEntityName();
            $entity = new $entityName;
            $entity->setCreatedAt(new DateTime());
        } else {
            $entity = $this->find($id);
        }

        $em = $this->getEntityManager();

        if (isset($params['username'])) {
            if (empty($params['username'])) {
                $entity->setUsername(null);
            } else {
                $entity->setUsername($params['username']);
            }
        }

        if (isset($params['email'])) {
            $entity->setEmail($params['email']);
        }

        if (isset($params['password'])) {
            if (empty($params['password'])) {
                $entity->setPassword(null);
            } else {
                $entity->setPassword($params['password']);
            }
        }

        if (isset($params['is_email_confirmed']) && $params['is_email_confirmed'] == Model_User::CONFIRMED) {
            $entity->setIsEmailConfirmed(Model_User::CONFIRMED);
        } else {
            $entity->setIsEmailConfirmed(Model_User::NOT_CONFIRMED);
        }

        if (isset($params['firstname'])) {
            $entity->setFirstname($params['firstname']);
        }

        if (isset($params['lastname'])) {
            $entity->setLastname($params['lastname']);
        }

        if (isset($params['title'])) {
            if (empty($params['title'])) {
                $entity->setTitle(null);
            } else {
                $entity->setTitle($params['title']);
            }
        }

        if (isset($params['fb_user_id'])) {
            if (empty($params['fb_user_id'])) {
                $entity->setFbUserId(null);
            } else {
                $entity->setFbUserId($params['fb_user_id']);
            }
        }

        if (isset($params['login_count'])) {
            $entity->setLoginCount($params['login_count']);
        }

        if (isset($params['debit_amount'])) {
            $entity->setDebitAmount($params['debit_amount']);
        }

        if (isset($params['avatar'])) {
            if (empty($params['avatar'])) {
                $entity->setAvatar(null);
            } else {
                $entity->setAvatar($params['avatar']);
            }
        }

        if (isset($params['birthDate'])) {
            if (empty($params['birthDate'])) {
                $entity->setBirthDate(null);
            } else {
                $entity->setBirthDate(DateTime::createFromFormat('d/m/Y', $params['birthDate']));
            }
        }

        if (isset($params['address'])) {
            if (empty($params['address'])) {
                $entity->setAddress(null);
            } else {
                $entity->setAddress($params['address']);
            }
        }

        if (isset($params['role_id'])) {
            $role = $em->getRepository('Entity_UserRoles')->find($params['role_id']);
            if ($role) {
                $entity->setRole($role);
            }
        }

        if (isset($params['country_id'])) {
            if (empty($params['country_id'])) {
                $entity->setCountry(null);
            } else {
                $country = $em->getRepository('Entity_Countries')->find($params['country_id']);
                if ($country) {
                    $entity->setCountry($country);
                }
            }
        }

        if (isset($params['city_id'])) {
            if (empty($params['city_id'])) {
                $entity->setCity(null);
            } else {
                $city = $em->getRepository('Entity_Cities')->find($params['city_id']);
                if ($city) {
                    $entity->setCity($city);
                }
            }
        }

        if (isset($params['municipality_id'])) {
            if (empty($params['municipality_id'])) {
                $entity->setMunicipality(null);
            } else {
                $municipality = $em->getRepository('Entity_Municipalities')->find($params['municipality_id']);
                if ($municipality) {
                    $entity->setMunicipality($municipality);
                }
            }
        }

        if (isset($params['gender'])) {
            if (empty($params['gender'])) {
                $entity->setGender(null);
            } else {
                $entity->setGender($params['gender']);
            }
        }

        if (isset($params['is_agree_terms_conditions'])
            && intval($params['is_agree_terms_conditions']) == Model_User::AGREE_TERMS_CONDITIONS) {
            $entity->setIsAgreeTermsConditions(Model_User::AGREE_TERMS_CONDITIONS);
        }

        if (isset($params['is_active'])) {
            if (empty($params['is_active'])) {
                $entity->setIsActive(Model_User::INACTIVE_USER);
            } else {
                $entity->setIsActive(Model_User::ACTIVE_USER);
            }
        }

        if (isset($params['twitterAccessToken'])) {
            if (empty($params['twitterAccessToken'])) {
                $entity->setTwitterAccessToken(null);
            } else {
                $entity->setTwitterAccessToken($params['twitterAccessToken']);
            }
        }

        if (isset($params['twitterAccessTokenSecret'])) {
            if (empty($params['twitterAccessTokenSecret'])) {
                $entity->setTwitterAccessTokenSecret(null);
            } else {
                $entity->setTwitterAccessTokenSecret($params['twitterAccessTokenSecret']);
            }
        }

        if (isset($params['confirmation_key'])) {
            if (empty($params['confirmation_key'])) {
                $entity->setConfirmationKey(null);
            } else {
                $entity->setConfirmationKey($params['confirmation_key']);
            }
        }

        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);

        return $entity;
    }

    /**
     * Update avatar by user
     * 
     * @param integer $userId
     * @param string $image
     * @param string $main
     * @return Entity_Users
     */
//    public function updateImage($userId, $image, $main)
//    {
//        $entity = $this->find($id);
//        $em = $this->getEntityManager();
//        
//        if (!$entity instanceof Entity_Users) {
//            throw new InvalidArgumentException('invalid entity from input parameter');
//        }
//
//        $imageEntity = new Entity_UserAttachments();
//        $imageEntity->setFilename($image);
//        $imageEntity->setMain($main);
//
//        $entity->addAttachment($imageEntity);
//        $em->persist($imageEntity);
//
//        $em->persist($entity);
//        return $entity;
//    }

    /**
     * Increment login count
     * 
     * @param integer $userId 
     * @return Entity_Users
     */
    public function incrementLoginCount($userId)
    {
        $userItem = $this->find($userId);
        $em = $this->getEntityManager();

        $currentLoginCount = $userItem->getLoginCount();
        $userItem->setLoginCount($currentLoginCount + 1);

        $em->persist($userItem);
        $em->flush();

        return $userItem;
    }

    /**
     * Update user password
     * 
     * @param array $params
     * @param type $userId
     * @return boolean 
     */
    public function updatePassword($params, $userId)
    {
        $entity = $this->find($userId);

        if ($entity) {
            $entity->setPassword($params['password']);
            $entity->setConfirmationKey(null);

            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        }

        return (bool) $entity;
    }

    /**
     * Set Facebook User ID to specific user
     * 
     * @param integer $fbUserId
     * @param integer $userId
     * @return boolean 
     */
    public function updateFacebookUserId($fbUserId, $userId)
    {
        $entity = $this->find($userId);

        if ($entity) {
            $entity->setFbUserId($fbUserId);

            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        }

        return (bool) $entity;
    }

    /**
     * Set confirmation key
     * 
     * @param integer $userId
     * @return boolean
     */
    public function setConfirmationKey($userId, $key)
    {
        $entity = $this->find($userId);

        if ($entity) {
            $entity->setConfirmationKey($key);

            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            return true;
        }

        return false;
    }

    /**
     * Set mail confirmed
     * 
     * @param integer $userId
     * @return boolean
     */
    public function setMailConfirmed($userId)
    {
        $entity = $this->find($userId);

        if ($entity) {
            $entity->setIsEmailConfirmed(1);
            $entity->setConfirmationKey(null);

            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            return true;
        }

        return false;
    }

    /**
     *
     * @param type $user_id
     * @param type $paramAmount
     * @return type 
     */
    public function deductAmount($user_id, $paramAmount)
    {
        $userEntity = $this->find($user_id);
        $ammount = $userEntity->getDebitAmount();
        $newAmount = $ammount - $paramAmount;
         
        
        $userEntity->setDebitAmount($newAmount);
        $this->getEntityManager()->persist($userEntity);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->refresh($userEntity);
        return $userEntity;
    }

    /**
     *
     * @param type $user_id
     * @param type $ammount
     * @return type 
     */
    public function addAmount($user_id, $paramAmount)
    {
        $userEntity = $this->find($user_id);
        $ammount = $userEntity->getDebitAmount();
        $newAmount = $ammount + $paramAmount;
        $userEntity->setDebitAmount($newAmount);
        $this->getEntityManager()->persist($userEntity);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->refresh($userEntity);
        return $userEntity;
    }
	
}