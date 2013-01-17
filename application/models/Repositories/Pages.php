<?php

use Doctrine\ORM\EntityRepository;

class Repository_Pages extends EntityRepository {

    /**
     * Create or update static page
     * 
     * @param array $params
     * @param Entity_Pages $pageId 
     */
    public function createOrUpdate(array $params, $pageId = null) {
        $em = $this->getEntityManager();

        if (is_null($pageId)) {
            $entityName = $this->getEntityName();
            $entity = new $entityName;
        } else {
            $entity = $this->find($pageId);
        }

        $entity->setTitle($params['title']);
        $entity->setSlug($params['slug']);
        $entity->setContent($params['content']);

        // Set meta keywords
        if (isset($params['meta_keywords']) && !empty($params['meta_keywords'])) {
            $entity->setMetaKeywords($params['meta_keywords']);
        } else {
            $entity->setMetaKeywords('');
        }

        // Set meta description
        if (isset($params['meta_description']) && !empty($params['meta_description'])) {
            $entity->setMetaDescription($params['meta_description']);
        } else {
            $entity->setMetaDescription('');
        }

        $em->persist($entity);
        $em->flush();
        $em->refresh($entity);
        

        return $entity;
    }

    /**
     * Remove page by ID
     * 
     * @param integer $id
     * @return Entity_Pages 
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
     * Get all static pages
     *
     * @param array $criteria
     * @param array $order
     * @return array 
     */
    public function getAll(array $criteria = array(), $order = array()) {
        $query = $this->createQueryBuilder('pages');

        if (!empty($criteria)) {
            $i = 0;
            foreach ($criteria as $key => $value) {
                if ($i == 0) {
                    $query->where("pages.{$key} = :{$key}");
                    $query->setParameter($key, $value);
                } else {
                    $query->andWhere("pages.{$key} = :{$key}");
                    $query->setParameter($key, $value);
                }

                $i++;
            }
        }
        
        if (!empty($order)) {
            $query->orderBy($order['sort'], $order['order']);
        }
        return $query;
    }


}