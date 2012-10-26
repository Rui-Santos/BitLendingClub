<?php


class App_Helper_Ajax 
{    
    public static function getCountryCityMunicipality($countryId = null, $cityId = null)
    {
        $result = array(
            'countryOpts' => array(),
            'cityOpts' => array(),
            'municipalityOpts' => array(),
        );
        
        // Countries should be populated by default
        $countryModel = new Model_Country();
        $result['countryOpts'] = $countryModel->getFormOpts();
        
        if ($cityId) {
            $cityModel = new Model_City();
            $cityItem = $cityModel->get($cityId);
                        
            $result['cityOpts'] = $cityModel->getFormOpts($cityItem->getCountry()->getId());
            
            $municipalityModel = new Model_Municipality();
            $result['municipalityOpts'] = $municipalityModel->getFormOpts($cityId);            
            
            return $result;
        }
        
        if ($countryId) {
            $cityModel = new Model_City();
            $result['cityOpts'] = $cityModel->getFormOpts($countryId);            
        }
        
        return $result;
    }
}