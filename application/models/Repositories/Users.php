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
        date_default_timezone_set('America/Chicago');
        
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

        if (isset($params['firstname'])) {
            $entity->setFirstname($params['firstname']);
        }

        if (isset($params['lastname'])) {
            $entity->setLastname($params['lastname']);
        }

        if (isset($params['address'])) {
            if (empty($params['address'])) {
                $entity->setAddress(null);
            } else {
                $entity->setAddress($params['address']);
            }
        }

        if (isset($params['role_id'])) {
            $role = $em->getRepository('Entity_Roles')->find($params['role_id']);
            if ($role) {
                $entity->setRole($role);
            }
        }

        
        $entity->setIsActive(Model_User::ACTIVE_USER);  

        
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
    
    public function deactivateUser($userId)
    {
        $entity = $this->find($userId);

        if ($entity) {
            $entity->setIsActive(0);
            
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            return true;
        }

        return false;
    }
    
    public function activateUser($userId)
    {
        $entity = $this->find($userId);

        if ($entity) {
            $entity->setIsActive(1);
            
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            return true;
        }

        return false;
    }
	
}