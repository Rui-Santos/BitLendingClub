<?php

use Doctrine\ORM\EntityRepository;

class Repository_Loans extends EntityRepository {

    /**
     * Get all Loans
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
     * Delete Loans by id
     * 
     * @param integer $id
     * @return Entity_Loans
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
     * Create or update Loans record
     * 
     * @param array $params
     * @param integer $id
     * @return Entity_Loans
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


        $entity->setTitle($params['title']);
        $entity->setAmount($params['amount']);
        $entity->setTerm($params['term']);
        $entity->setDescription($params['description']);
        $entity->setFrequency($params['frequency']);
        $entity->setPurpose($params['purpose']);
        $expiration = date_create_from_format('d/m/Y', $params['expirationDate']);
       
        $entity->setExpirationDate($expiration);
        
        $status = $em->getRepository('Entity_Loanstatus')->find(1);
        if ($status) {
            $entity->setStatus($status);
        }

        $borrower = $em->getRepository('Entity_Users')->find($params['user_id']);
        if ($borrower) {
            $entity->setBorrower($borrower);
        }


        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);

        return $entity;
    }

}