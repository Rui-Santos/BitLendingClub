<?php

use Doctrine\ORM\EntityRepository;

class Repository_Wallets extends EntityRepository
{

    /**
     * Get all Wallets
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
     * Delete Wallet by id
     * 
     * @param integer $id
     * @return Entity_Wallets
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
     * Create or update wallet record
     * 
     * @param array $params
     * @param integer $id
     * @return Entity_Wallets
     */
    public function createOrUpdate(array $params, $id = null)
    {
        if (!isset($params['user_id'])) {
            throw new Exception('Invalid parameter set: user_id');
        }
        if (is_null($id)) {
            $entityName = $this->getEntityName();
            $entity = new $entityName;
        } else {
            $entity = $this->find($id);
        }
        $em = $this->getEntityManager();
        $user = $em->getRepository('Entity_Users')->find($params['user_id']);
        if (!$user) {
            throw new Exception('No user with this id: user_id');
        }

        $entity->setUser($user);
        $entity->setWalletPath($params['address']);
        $entity->setBalance($params['balance']);

        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);

        return $entity;
    }

    /**
     * 
     * @param array $params
     * @return type
     * @throws InvalidArgumentException
     */
    public function update($params = array())
    {
        $em = $this->getEntityManager();
        $entity = $this->findOneBy(array('user' => $params['user']));
        if (!$entity) {
            throw new InvalidArgumentException('invalid user_id for wallet');
        }

        $params['user'] = $this->_em->getRepository('Entity_Users')->find($params['user']);
        foreach ($params as $key => $value) {
            $setter = join('', array("set", ucfirst($key)));

            call_user_func_array(array($entity, $setter), array($value));
        }
        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);
        return $entity;
    }

}