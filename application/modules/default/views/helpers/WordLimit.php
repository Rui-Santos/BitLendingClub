<?php

class Default_View_Helper_WordLimit extends Zend_View_Helper_Abstract
{

    public function wordLimit($str, $limit, $suffix = ' ...')
    {
        $words = explode(" ", $str);
        if (count($words) > $limit) {
            return implode(" ", array_splice($words, 0, $limit)) . $suffix;
        } else {
            return $str;
        } 
    }
}