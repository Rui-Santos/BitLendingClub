<?php

class App_Search_Adapter_Db
{
    const METHOD_NAME = "search";

    /**
     *
     * @var type 
     */
    protected $_models = array();

    /**
     *
     * @param type $models
     * @return \App_Search_Adapter_Db 
     */
    public function __construct($models = array())
    {
        $this->_models = $models;
        return $this;
    }

    /**
     *
     * @param type $phrase
     * @return type 
     */
    public function query($phrase)
    {
        $response = array();
        foreach ($this->_models as $key => $model) {
            $response[$key] = call_user_func_array(array($model, self::METHOD_NAME), array("phrase" => $phrase));
        }
        return $response;
    }

}