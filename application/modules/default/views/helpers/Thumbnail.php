<?php
/**
 * @author Yasen Yankov
 * 
 *  Thumbnail generator (caching live images) for zend view with phpThumb
 *  usage: $this->thumbnail(imagePath, width, height) all required parameters
 *  
 */
class Zend_View_Helper_Thumbnail extends Zend_View_Helper_Abstract
{
    const DEFAULT_IMAGE = "default.jpg";
    
    protected $_phpThumbUrl;

    public function setPhpThumbUrl($url)
    {
        $this->_phpThumbUrl = $url;
    }

    public function thumbnail($path, $name, $width, $height)
    {
        if ($path == '') {
            throw new InvalidArgumentException('invalid parameter $path posted 
                to thumbnail method. Please add path to image');
        }

        if ($width == 0 || $height == 0) {
            throw new InvalidArgumentException('please provide widht & height for
                the image as they are not optional fields');
        }
        
        $this->setPhpThumbUrl('/phpthumb/phpThumb.php');
        $name = $this->noName($name);
        return $this->_phpThumbUrl . '?src=' . $path . $name ."&w=" . $width . "&h=" . $height;
    }
    
    public function noName($name)
    {
        if ($name == "") {
            return self::DEFAULT_IMAGE;
        }
        return $name;
    }

}