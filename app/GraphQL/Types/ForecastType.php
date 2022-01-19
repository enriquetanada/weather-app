<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Models\Weather;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;


class ForecastType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ForecastType',
        'description' => 'A forecast type information',
        'model' => Weather::class,
    ];

    public function fields(): array
    {
        return [
            'min_temp' => [  
                'type' => Type::float(),    
            ],
            'max_temp' => [  
                'type' => Type::float(),    
            ],
            'feels_like' => [  
                'type' => Type::float(),    
            ],
            'temp' => [  
                'type' => Type::float(),    
            ],
            'date' => [  
                'type' => Type::string(),    
            ],
            'weather' => [  
                'type' => Type::string(),    
            ],
            'wind_speed' => [  
                'type' => Type::float(),    
            ],
            'pop' => [  
                'type' => Type::float(),    
            ],
        ];
    }
}
?>
