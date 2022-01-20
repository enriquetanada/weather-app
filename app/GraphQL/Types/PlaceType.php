<?php

namespace App\GraphQL\Types;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Models\Weather;
use GraphQL\Type\Definition\CustomScalarType;
use Crypt;


class PlaceType extends GraphQLType
{
    protected $attributes = [
        'name' => 'PlaceType',
        'description' => 'A place type information',
        'model' => Weather::class,
    ];

    public function fields(): array
    {
        return [
            'name' => [  
               'type' => Type::string(),    
            ],
            'image' => [  
                'type' => Type::string(),    
            ],
            'address' => [
                'type' => Type::string(),
            ]
        ];
    }
}
?>
