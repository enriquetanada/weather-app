<?php
namespace App\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Log;
use App\Models\Weather;


class WeatherQuery extends Query
{
   protected $attributes = [
       'name' => 'WeatherQuery'
   ];
   public function args(): array
   {
      return [
         'city' => ['type' => Type::string()],
      ];
   }

   public function type(): Type {
        return GraphQL::type('weather');
   }

   public function resolve($root, $args){
      $weather = new Weather();
      $city = $args['city'];
      $weather_details = $weather->getWeather($city);
      return $weather_details;
   }

}
?>
