<?php

use Doctrine\ORM\EntityRepository;

class Repository_LoanComments extends EntityRepository
{

    /**
     * Get all loan comments
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
     * Delete comment by id
     * 
     * @param integer $id
     * @return Entity_LoanComments
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
     * Create or update comment record
     * 
     * @param array $params
     * @param integer $id
     * @return Entity_LoanComments
     */
    public function createOrUpdate(array $params, $id = null)
    {
        if (is_null($id)) {
            $entityName = $this->getEntityName();
            $entity = new $entityName;
            $entity->setPostedOn(new DateTime());
        } else {
            $entity = $this->find($id);
        }
        
        $em = $this->getEntityManager();

        $entity->setComment($params['comment']);
      
        $status = $em->getRepository('Entity_Loans')->find($params['loan_id']);
        if ($status) {
            $entity->setLoan($status);
        }

        $borrower = $em->getRepository('Entity_Users')->find($params['user_id']);
        if ($borrower) {
            $entity->setUser($borrower);
        }
        
        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);

        return $entity;
       
    }

}