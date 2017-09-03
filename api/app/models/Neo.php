<?php

/**
 * Copyright (C) 2017-2018 Ravindra Miyani - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Ravindra Miyani <mys6666@gmail.com>
 *
 * @author      Ravindra Miyani
 * @copyright   2017-2018 Ravindra Miyani
 * @license     
 * @version
 * @link
 * @see
 * @since
 */


use Phalcon\Mvc\Model;

/**
 * Class Neo contains model methods that are callable by the restful routes from NeoController. These methods  * interact with database and get the results accordingly.
 *
 */

class Neo extends Model
{
 
 	/**
     * This function is used to get all the potentially hazardous/non-hazardous asteroids.
     * 
     * @param $is_haz variable as a true or false. By Default it is false. 
     * @return mixed JSON response as a object
     */

	public static function getAllByHazType($is_haz = 0){
        
        $result_set = Neo::find(
					        	array(
					            "conditions"    => " is_hazardous = :is_haz:",
					            "bind"          => array("is_haz" => $is_haz)
					        	)
							);
        return $result_set;
    }


    /**
     * This function is used to get fastest potentially hazardous/non-hazardous asteroids.
     * 
     * @param $is_haz variable as a true or false. By Default it is false. 
     * @return mixed JSON response as a object
     */
 	
	public static function getFastestAteroid($is_haz = 0){
       
        $result_set = Neo::find(
					        	array(
					            "conditions"    => " is_hazardous = :is_haz:",
					            "bind"          => array("is_haz" => $is_haz),
					            "order" 		=> "speed DESC",
					            "limit"			=> 1
					        	)
							);
        return $result_set;
    }

    /**
     * This function is used to get year with most asteroids.
     * 
     * @param $is_haz variable as a true or false. By Default it is false. 
     * @return mixed JSON response as a object
     */

    public static function getBestYearAteroid($is_haz = 0){
       
        $result_set = Neo::find(
					        	array(
					            "conditions"    => " is_hazardous = :is_haz:",
					            "bind"          => array("is_haz" => $is_haz),
					            "columns"		=> "YEAR(neo_date) AS neo_best_year,COUNT(*) AS total_number_of_ateroids",
					            "group"			=> "neo_best_year",
					            "order" 		=> "total_number_of_ateroids DESC",
					            "limit"			=> 1
					        	)
							);
        return $result_set;

        // SQL Query : select YEAR(neo_date),COUNT(*) AS 'N_DATE' from neo where is_hazardous = 1 GROUP BY YEAR(neo_date) ORDER BY N_DATE DESC limit 1

    }
    

    /**
     * This function is used to get month with most asteroids.
     * 
     * @param $is_haz variable as a true or false. By Default it is false. 
     * @return mixed JSON response as a object
    */

    public static function getBestMonthAteroid($is_haz = 0){
       
        $result_set = Neo::find(
					        	array(
					            "conditions"    => " is_hazardous = :is_haz:",
					            "bind"          => array("is_haz" => $is_haz),
					            "columns"		=> "MONTH(neo_date) AS neo_best_month,COUNT(*) AS total_number_of_ateroids",
					            "group"			=> "neo_best_month",
					            "order" 		=> "total_number_of_ateroids DESC",
					            "limit"			=> 1
					        	)
							);
        return $result_set;

        // SQL Query : select MONTH(neo_date),COUNT(*) AS 'N_DATE' from neo where is_hazardous = 1 GROUP BY MONTH(neo_date) ORDER BY N_DATE DESC limit 1

    }






}