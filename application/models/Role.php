<?php

class Model_Role extends Model_Abstract
{

    /**
     * Define entityName based on model
     * @var string
     */
    protected $_entityName = 'Entity_Roles';

    /**
     * All types of transactions type id's that are added to total savings
     * @return arrau
     */
    public static $transactionTypesAddedToSavings = array(1, 2);

    /**
     * Create document type by specific params 
     *
     * @param array $params
     * @return Entity_DocumentTypes
     */
    public function create(array $params)
    {
        if (empty($params)) {
            throw new InvalidArgumentException('Invalid argument: params');
        }

        return $this->getRepository()->createOrUpdate($params, null);
    }

    /**
     * Update document type by specific params
     *
     * @param array $params
     * @param integer $documentId
     * @return Entity_DocumentTypes
     */
    public function update(array $params, $documentId)
    {
        if (empty($params) || intval($documentId) == 0) {
            throw new InvalidArgumentException('Invalid arguments');
        }
        
        return $this->getRepository()->createOrUpdate($params, $documentId);
    }

}