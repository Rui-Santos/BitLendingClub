<?php

class App_Helper_Util 
{    
    public static function generateRandomString($length) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';    
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }
        
        return $string;
    }    
    
    public static function formatPrice($input, $precision = 2, $decPoint = '.', $thousandsSep = '') 
    {
        return number_format($input, $precision, $decPoint, $thousandsSep);
    }
    
    public static function formatWorkingTime($workingTimes) 
    {
    	$result = array();
    	
    	$days = array(1 => 'пон', 2 => 'вто', 3 => 'сре', 4 => 'чет', 5 => 'пет', 6 => 'саб', 7 => 'нед');
    	
//    	foreach ($workingTimes as $time) {
//    		echo $time->getWeekDay().": ".$time->getFromTime().'-'.$time->getToTime()."(".$time->getIsWorkingDay().")</br>";
//    	}
    	
    	$previous = null;
    	$lastSameDay = 1;
    	
		foreach ($workingTimes as $ind => $time) {
			if ($ind == 0) continue;
			
			$previous = $workingTimes[$ind - 1];
						
			if ($time->getIsWorkingDay()) {
				//echo $days[$workingTimes[$ind]->getWeekDay()]."  .-.-.</br>";
					
				if ($previous != null &&
					$previous->getIsWorkingDay() && (
						$previous->getFromTime() != $time->getFromTime() ||
						$previous->getToTime() != $time->getToTime() )) { 

					if ($previous->getWeekDay() > $lastSameDay) {
						$result[$days[$lastSameDay].'-'.$days[$previous->getWeekDay()]] = $previous;
					} else {
						$result[$days[$lastSameDay]] = $previous;
					}
					
					$lastSameDay = $time->getWeekDay();
					
				} else if ($previous == null || !$previous->getIsWorkingDay()) {
					$lastSameDay = $time->getWeekDay();
				}
				
				if ($time->getWeekDay() == 7) {
					if (($previous->getIsWorkingDay() && (
						$previous->getFromTime() != $time->getFromTime() ||
						$previous->getToTime() != $time->getToTime() )) || $time->getWeekDay() == $lastSameDay) {
						
						$result[$days[7]] = $time;
					
					} else {
						$result[$days[$lastSameDay].'-'.$days[$time->getWeekDay()]] = $time;
					}
					
				}
			} else if ($previous->getIsWorkingDay()) {
				if ($previous->getWeekDay() > $lastSameDay) {
					$result[$days[$lastSameDay].'-'.$days[$previous->getWeekDay()]] = $previous;
				} else {
					$result[$days[$lastSameDay]] = $previous;
				}
				$lastSameDay = $time->getWeekDay();				
			}
		}

		return $result;
    }
}