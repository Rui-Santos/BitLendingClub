<?php

use Doctrine\ORM\EntityRepository;

class Repository_Loans extends EntityRepository
{

    /**
     * Get all ratings
     * 
     * @param array $criteria
     * @return array 
     */
    public function getAll(array $criteria = array())
    {
        $query = $this->createQueryBuilder('userRatings');

        if (!empty($criteria)) {
            $i = 0;
            foreach ($criteria as $key => $value) {
                if ($i == 0) {
                    $query->where("userRatings.{$key} = :{$key}");
                    $query->setParameter($key, $value);
                } else {
                    $query->andWhere("userRatings.{$key} = :{$key}");
                    $query->setParameter($key, $value);
                }

                $i++;
            }
        }

        return $query;
    }

    /**
     * Delete ratings by id
     * 
     * @param integer $id
     * @return Entity_Loans
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
     *
     * @param array $params
     * @param type $id 
     */
    public function createOrUpdate(array $params, $id = null)
    {
        $em = $this->getEntityManager();
        if (is_null($id)) {
            $entityName = $this->getEntityName();
            $entity = new $entityName;
        } else {
            $entity = $this->find($id);
        }
        $usersRepository = $em->getRepository("Entity_Users");
        $user = $usersRepository->find($params['user_id']);
        $commenter = $usersRepository->find($params['commenter_id']);

        $entity->setRating($params['rating']);
        $entity->setComment($params['comment']);
        $entity->setCommenter($commenter);
        $entity->setUser($user);

        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);

        return $entity;
    }

}