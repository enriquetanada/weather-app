<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Models\Weather;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;


class WeatherType extends GraphQLType
{
    protected $attributes = [
        'name' => 'WeatherType',
        'description' => 'A weather type information',
        'model' => Weather::class,
    ];

    public function fields(): array
    {
        return [
            'error' => [  
               'type' => Type::boolean(),    
            ],
            'message' => [  
                'type' => Type::string(),    
            ],
            'forecasts' => [
                'type' => Type::listOf(GraphQL::type('forecast')),
            ]
        ];
    }
}
?>
