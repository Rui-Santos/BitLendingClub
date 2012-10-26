<?php

/**
 * 
 */
class Default_View_Helper_Date extends Zend_View_Helper_Abstract
{

    public function date($param)
    {
        if (is_array($param)) {
            return $param["date"];
        } else {
            $dateObject = new Zend_Date($param);
            return $dateObject->get(Zend_Date::DATETIME);
        }
    }

}