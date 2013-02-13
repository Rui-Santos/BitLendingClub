<?php

use Doctrine\ORM\EntityRepository;

class Repository_Wallets extends EntityRepository {

    /**
     * Get all Wallets
     * 
     * @param array $criteria
     * @return array 
     */
    public function getAll(array $criteria = array()) {
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
    public function delete($id) {
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
    public function createOrUpdate(array $params, $id = null) {
        date_default_timezone_set('America/Chicago');

        if (is_null($id)) {
            $entityName = $this->getEntityName();
            $entity = new $entityName;
        } else {
            $entity = $this->find($id);
        }

        $em = $this->getEntityManager();

        $btcuser = Zend_Registry::get('config')->btc->conn->user;
        $btcpass = Zend_Registry::get('config')->btc->conn->pass;
        $btcurl = Zend_Registry::get('config')->btc->conn->host;
        $bitcoin = new App_jsonRPCClient('http://' . $btcuser . ':' . $btcpass . '@' . $btcurl . '/');

        if (isset($params['user_id'])) {
            $user = $em->getRepository('Entity_Users')->find($params['user_id']);
            if ($user) {
                $entity->setUser($user);
            }
        }

        $address = $bitcoin->getaccountaddress('account_' . $params['user_id']);
        $entity->setWalletPath($address);
        $balance = $bitcoin->getbalance('account_' . $params['user_id']);
        $entity->setBalance($balance);

        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);

        return $entity;
    }

}