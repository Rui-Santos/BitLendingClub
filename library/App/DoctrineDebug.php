<?php

class App_DoctrineDebug
{

    public static function dump($var, $maxDepth = 2)
    {
        echo "<pre>";
        Doctrine\Common\Util\Debug::dump($var, $maxDepth);
        echo "</pre>";
    }

}