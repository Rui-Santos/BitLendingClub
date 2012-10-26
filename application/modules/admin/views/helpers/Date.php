<?php

class Admin_View_Helper_Date extends Zend_View_Helper_Abstract
{
    /**
     *
     * @var type 
     */
    protected $_format;

    public function date($input, $format = "m/d/Y h:i")
    {
        $this->_format = $format;
        return $this->_operate($input);
    }
    /**
     *
     * @param DateTime $input
     * @return type 
     */
    protected function _operate($input)
    {
        if ($input instanceof DateTime) {
            return $input->format($this->_format);
            
        } elseif (is_numeric($input)) {
            $returnedDate = new DateTime($input);
            return $returnedDate->format($this->_format);
        }
    }

}