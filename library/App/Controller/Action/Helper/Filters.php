<?php
/**
 *
 *  
 */
class App_Controller_Action_Helper_Filters extends Zend_Controller_Action_Helper_Abstract
{
    const SESSION_KEY = 'filterParams';
    
    const TYPE_POST = 'post';
    
    const TYPE_SESSION = 'session';
    /**
     *
     * @var type 
     */
    protected $_params = array(); 
    
    /**
     * 
     */
    public function applyFilters()
    {
        $this->_resetRequestParameters()
                ->_prerequisites();
        
        $this->getActionController()->view->params = $this->_params;
        
    }
   /**
     * 
     */
    protected function _prerequisites()
    {
        if (isset($this->_params['cid'])) {
            $cid = $this->_params['cid'];
            $this->_reset();
            $this->set("categories", array($cid));
        }
        
    }
   /**
    *
    * @return \App_Controller_Action_Helper_Filters 
    */
    protected function _resetRequestParameters()
    {
        $params = $this->getRequest()->getParams();
        unset ($params['controller']);
        unset ($params['module']);
        unset ($params['action']);
        $this->_params = $params;
        return $this;
    }
    /**
     *
     * @return \App_Controller_Action_Helper_Filters 
     */
    public function _reset()
    {
        $this->_params = array();
        return $this;
    }
    /**
     *
     * @param type $key
     * @param type $value
     * @return \App_Controller_Action_Helper_Filters 
     */
    public function set($key, $value)
    {
        $this->_params[$key] = $value;
        return $this;
    }
}
