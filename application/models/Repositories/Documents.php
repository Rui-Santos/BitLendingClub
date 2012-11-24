<?php

use Doctrine\ORM\EntityRepository;

class Repository_Documents extends EntityRepository
{

    /**
     * Get all documents
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
     * Delete document by id
     * 
     * @param integer $id
     * @return Entity_Documents 
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
     * Create or update a document
     * 
     * @param array $params
     * @param integer $id
     * @return Entity_Documents
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

        if (isset($params['document_path'])) {
            if (empty($params['document_path'])) {
                $entity->setDocumentPath(null);
            } else {
                $entity->setDocumentPath($params['document_path']);
            }
        }

//        if (isset($params['role_id'])) {
//            $role = $em->getRepository('Entity_UserRoles')->find($params['role_id']);
//            if ($role) {
//                $entity->setRole($role);
//            }
//        }


        
        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);

        return $entity;
    }
	
}