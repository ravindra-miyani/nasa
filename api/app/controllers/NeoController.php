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



/**
 * Class NeoController contains methods that are callable by the restful routes. These methods interact with 
 * database to perform complex CRUD operations for NEO data. The methods also send back proper response to 
 * the frontend.
 */

class NeoController extends BaseController
{
    
    /**
     * This function is used to get NEO data of last 3 days from nasa api. Nasa api only provides 7 days data at a time. 
     * 
     * @param void
     * @return mixed JSON response
     */

    public function getAllFromNASA(){

        $toDate     = date('Y-m-d'); 
        $fromDate   = date('Y-m-d', strtotime($toDate .' -7 day'));
        $url        = "https://api.nasa.gov/neo/rest/v1/feed?start_date=".$fromDate."&end_date=".$toDate."&detailed=true&api_key=N7LkblDsc5aen05FJqBQ8wU4qSdmsftwJagVK7UD";
        $ch         = curl_init(); // Curl inistilization.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result     = curl_exec($ch);
        curl_close($ch);
        $result_set = json_decode($result, true); // Store Response of NASA API.

        if(isset($result_set['code'])){
            $this->sendErrorResponse(array('message' => $result_set));
        }else{
            $data = array();
            foreach ($result_set['near_earth_objects'] as $key => $value) {
                foreach ($value as $keyOne => $valueOne) {
                    $data[] = array('neo_date' => $key,'reference_id' => $valueOne['neo_reference_id'],'name' => $valueOne['name'],'speed' => $valueOne['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'],'is_hazardous' => $valueOne['is_potentially_hazardous_asteroid']);
                }
            }
            

            if(count($data) > 0) {
                foreach ($data as $key => $value) {
                    $neoObj     = new Neo();
                    $objSave    = $neoObj->save($value);
                }
            }
            $this->sendSuccessResponse(array('message' => 'Data saved successfully'));
        }
    }


    /**
     * This function is used to get all the potentially hazardous asteroids.
     * 
     * @param void
     * @return mixed JSON response
     */

    public function getAllHazardous(){

        $data['result_set'] = array();
        $records            = Neo::getAllByHazType(1);
        $data['count']      = count($records);

        if (count($records) > 0) {
            foreach ($records as $record) {
                $data['result_set'][] = $record->toArray();
            }
        }

        $this->sendSuccessResponse($data);
    }


    /**
     * This function is used to get fastest potentially hazardous/non-hazardous asteroids based on specified parameter. By default it will get fastest non-hazardous asteroids.
     * 
     * @param $is_hazardous variable as a true or false. By Default it is false.
     * @return mixed JSON response of fastest potentially hazardous/non-hazardous asteroids 
     */

    public function getFastestHazNonHaz($is_hazardous = 0 ){


        $is_haz             = ($is_hazardous === "true") ? 1 : 0;  
        $data['result_set'] = array();
        $records            = Neo::getFastestAteroid($is_haz);
        $data['count']      = count($records);

        if(count($records) > 0) {
            foreach ($records as $record) {
                $data['result_set'][] = $record->toArray();
            }
        }

        $this->sendSuccessResponse($data);
    }


    /**
     * This function is used to get year with most ateroids based on specified parameter. By default it will get year with most non-hazardous ateroids. 
     * 
     * @param $is_hazardous variable as a true or false. By Default it is false.
     * @return mixed JSON response of year with most ateroids.
     */

    public function getBestYearHazNonHaz($is_hazardous = 0 ){


        $is_haz             = ($is_hazardous === "true") ? 1 : 0;  
        $data['result_set'] = array();
        $records            = Neo::getBestYearAteroid($is_haz);
        $data['count']      = count($records);

        if(count($records) > 0) {
            foreach ($records as $record) {
                $data['result_set'][] = $record->toArray();
            }
        }

        $this->sendSuccessResponse($data);
    }    


    /**
     * This function is used to get month with most ateroids based on specified parameter. By default it will get month with most non-hazardous ateroids. 
     * 
     * @param $is_hazardous variable as a true or false. By Default it is false.
     * @return mixed JSON response of month with most ateroids.
     */

    public function getBestMonthHazNonHaz($is_hazardous = 0 ){


        $is_haz             = ($is_hazardous === "true") ? 1 : 0;  
        $data['result_set'] = array();
        $records            = Neo::getBestMonthAteroid($is_haz);
        $data['count']      = count($records);

        if(count($records) > 0) {
            foreach ($records as $record) {
                $data['result_set'][] = $record->toArray();
            }
        }

        $this->sendSuccessResponse($data);
    }    




}