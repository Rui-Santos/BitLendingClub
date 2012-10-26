<?php

/**
 * 
 */
class App_Paginator_Adapter_SolrQuery implements Zend_Paginator_Adapter_Interface
{

    /**
     *
     * @var type 
     */
    private $query;

    /**
     *
     * @var type 
     */
    private $client;

    /**
     *
     * @param SolrQuery $query
     * @param SolrClient $client 
     */
    public function __construct(SolrQuery $query, $client)
    {
        $this->query = $query;
        $this->client = $client instanceof SolrClient ? $client : new SolrClient($client);
    }

    /**
     *
     * @return type 
     */
    public function count()
    {
        $this->query->setRows(0);
        return $this->execute()->numFound;
    }

    /**
     *
     * @param type $offset
     * @param type $itemCountPerPage
     * @return type 
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $this->query->setStart($offset)->setRows($itemCountPerPage);
        return $this->execute()->docs;
    }

    /**
     *
     * @return type 
     */
    private function execute()
    {
        $response = $this->client->query($this->query)->getResponse();
        return $response['response'];
    }

}