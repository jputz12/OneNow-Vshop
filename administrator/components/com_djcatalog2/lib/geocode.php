<?php
/**
 * @version $Id: geocode.php 373 2015-02-10 08:41:53Z michal $
 * @package DJ-Catalog2
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Michal Olczyk - michal.olczyk@design-joomla.eu
 *
 * DJ-Catalog2 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Catalog2 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Catalog2. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// No direct access.
defined('_JEXEC') or die();

jimport( 'joomla.application.component.controller' );

class DJCatalog2Geocode {
	
	static private $url = "http://maps.google.com/maps/api/geocode/json?sensor=false";

    public static function getLocation($address){
        $url = self::$url."&address=".urlencode($address);
       
        $resp_json = self::curl_file_get_contents($url);
        $resp = json_decode($resp_json, true);

        if($resp['status']='OK' && isset($resp['results'][0])){
            return $resp['results'][0]['geometry']['location'];
        }else{
            return false;
        }
    }
    
    public static function getLocationPostCode($post_code, $country=''){
    	//$post_code = str_ireplace(array(' ','-'), array('',''), $post_code);
    	$url_zip = '';
    	if($country){
    		$url_zip = '&address='.urlencode($country);
    	}
    	$url = self::$url.$url_zip."&components=postal_code:".urlencode($post_code);
    	 
    	$resp_json = self::curl_file_get_contents($url);
    	$resp = json_decode($resp_json, true);
    	if($resp['status']='OK' && isset($resp['results'][0])){
    		return $resp['results'][0]['geometry']['location'];
    	}else{
    		return false;
    	}
    }


    private static function curl_file_get_contents($URL){
    	if (!in_array('curl', get_loaded_extensions())) {
    		return false;
    	}
        
    	$c = curl_init();
        
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($c, CURLOPT_URL, $URL);
        
        $contents = curl_exec ($c);
        
        if(curl_errno($c)) {
        	curl_close ($c);
        	return false;
        }
        
        curl_close ($c);

        return (empty($contents)) ? false : $contents;
    }
}
