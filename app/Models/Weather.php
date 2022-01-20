<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use GuzzleHttp\Client;

class Weather extends Eloquent
{
    use HasFactory;

    private $api_key_weather = "d23c1d264aa09b22b682ab3306e6494b";
    private $api_key_place = "fsq3BsQe9Q1VgDfSdnYDAn3dexdUOueubahslsrmWzSH2Yo=";  

    public function getWeather($city){

        $default_place = 'Tokyo';
        
        if($city) {
            $responses = self::getCityWeather($city);
        } else {
            $responses = self::getCityWeather($default_place);
        }
        return $responses;
    }

    private function getCityWeather($city) {
       
        $client = new Client();
        $response = new \stdClass();
        try {
            $res = $client->get('https://api.openweathermap.org/data/2.5/forecast?q='.$city.'&appid='.$this->api_key_weather.'&units=metric');
            $responses = json_decode($res->getBody()->getContents());
           
            $after_hour = date('H:i:s', strtotime(' + 2 hours'));
            $before_hour = date('H:i:s', strtotime(' - 1 hours'));
            $filtered_output = [];
            $filtered_time = [];
            foreach($responses->list as $list) {
                $time = date('H:i:s', strtotime($list->dt_txt));
                if($time > $before_hour && $time < $after_hour && $after_hour > $before_hour) {
                    $response_obj = self::returnObject($list);
                    array_push($filtered_output, $response_obj);
                } 
                if($time == "00:00:00"){
                    $response_obj = self::returnObject($list);
                    array_push($filtered_time, $response_obj);
                }
            }
            $response->error = false;
            $response->message = 'Valid Place';
            $response->forecasts = $filtered_output ? $filtered_output : $filtered_time;
            $response->places = self::getNearPlaces($city);
        } catch(\GuzzleHttp\Exception\ClientException $e){
            $response->error = true;
            $response->message = 'Invalid Place';
            $response->forecasts = null;
        } finally {
            return $response;
        }
       
    }
    private function returnObject($list){
        $response_obj = new \stdClass();

        $response_obj->min_temp = $list->main->temp_min;
        $response_obj->max_temp = $list->main->temp_max;
        $response_obj->feels_like = $list->main->feels_like;
        $response_obj->temp = $list->main->temp;
        $response_obj->date = $list->dt_txt;
        $response_obj->weather = $list->weather[0]->main;
        $response_obj->wind_speed = $list->wind->speed;
        $response_obj->pop = $list->pop;

        return $response_obj;
    }

    private function getNearPlaces($city){
        
        $client = new Client();
        $response;
        try {
            $res = $client->request('GET', 'https://api.foursquare.com/v3/places/search?near='.$city, [
                'headers' => [
                  'Accept' => 'application/json',
                  'Authorization' => $this->api_key_place,
                ],
              ]);
            $responses = json_decode($res->getBody()->getContents());
            $filtered_output = [];
            foreach($responses->results as $resp) {
                $response_obj = new \stdClass();
                $image = $client->request('GET', 'https://api.foursquare.com/v3/places/'.$resp->fsq_id.'/photos', [
                        'headers' => [
                          'Accept' => 'application/json',
                          'Authorization' => $this->api_key_place,
                        ],
                    ]);
                $image_decode = json_decode($image->getBody()->getContents());
                $resp->image = 
                $resp->address = $resp->location->address;
                $response_obj->image = $image_decode[0]->prefix . '400x400' . $image_decode[0]->suffix;
                $response_obj->name = $resp->name;
                $response_obj->address = $resp->location->address;
                array_push($filtered_output,  $response_obj);
            }    
            $response = $filtered_output;
            
        } catch(\GuzzleHttp\Exception\ClientException $e){
            $response = $e;
        } finally {
            return $response;
        }
       
    }
}