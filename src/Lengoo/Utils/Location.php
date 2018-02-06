<?php

/**
 * Created by PhpStorm.
 * User: khan-muhammad
 * Date: 5/19/17
 * Time: 12:10 AM
 */
namespace Lengoo\Utils;

class Location
{
    public static function findLocationFromIp($clientIp){

        $apiUrl="http://ip-api.com/json/".$clientIp;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
                           ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
         //   echo "cURL Error #:" . $err;
        } else {
            return $response;
        }


    }

}