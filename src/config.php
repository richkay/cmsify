<?php

return [

    // !TODO: implement configs
    "models" => [
        "post" => [
            "class" => App\Post::class,
            "relations" => [
                'locations' => [
                    'model' => \App\Location::class,
                    'label' => 'Locations',
                    'multiple' => true,
                ]
            ]
        ]
    ],

    "images" => [
        'maxfilesize' => 2000,
        'maxheight' => 800,
        'maxwidth' => 800,
        'quality' => 65,
        'intervention_driver' => 'gd',
        'storage_path' => storage_path('cmsify/images')
    ],

    "categories" => [
        "disabled" => false,
        "maxLevel" => 2,
    ],

    "tags" => [
        "disabled" => false
    ],

];
