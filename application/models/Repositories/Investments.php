<?php

use Doctrine\ORM\EntityRepository;

class Repository_Investments extends EntityRepository
{

    /**
     * Get all Investments
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
     * Delete Investments by id
     * 
     * @param integer $id
     * @return Entity_Investments
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
     * Create or update Investments record
     * 
     * @param array $params
     * @param integer $id
     * @return Entity_Investments
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

       //TODO: CREATE/UPDATE Investments
        
        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);

        return $entity;
       
    }

}