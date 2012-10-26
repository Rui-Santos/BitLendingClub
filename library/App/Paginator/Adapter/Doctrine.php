<?php

use Doctrine\ORM\QueryBuilder;

class App_Paginator_Adapter_Doctrine implements Zend_Paginator_Adapter_Interface
{

    /**
     * Query
     *
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $_query = null;

    /**
     * The count query
     * 
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $_countQuery = null;

    /**
     * Total item count
     *
     * @var int
     */
    protected $_rowCount;

    /**
     * Constructor.
     *
     * @param \Doctrine\ORM\QueryBuilder
     */
    public function __construct(QueryBuilder $query)
    {
        $this->_query = $query;
    }

    /**
     * Returns the total number of rows in the result set.
     *
     * @return integer
     */
    public function count()
    {
        if ($this->_rowCount === null) {
            $this->prepareCountQuery();
            $this->_rowCount = $this->_countQuery->getQuery()->getSingleScalarResult();
        }
        return $this->_rowCount;
    }

    /**
     * Returns an array of items for a page.
     *
     * @param  integer $offset Page offset
     * @param  integer $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $this->_query->setFirstResult($offset);
        $this->_query->setMaxResults($itemCountPerPage);
        return $this->_query->getQuery()->execute();
    }

    /**
     * Preapre the count query
     */
    protected function prepareCountQuery()
    {

        $query = clone $this->_query;

        // Set select COUNT([alias])
        $alias = $query->getRootAlias();
        $query->select($query->expr()->count($alias));

        $this->_countQuery = $query;
    }

}