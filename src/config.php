<?php

return [

    "permissions" => [
        'onlyCreatorCanEdit' => true,
        'onlyCreatorCanDelete' => true,
    ],

    // !TODO: its just for dev purpose, must delete or replace with some useful relation
    "models" => [
        "post" => [
            "class" => App\Post::class,
            "relations" => [
                'locations' => [
                    'label' => 'Locations',
                    'multiple' => true,
                ]
            ]
        ]
    ],

    // !TODO: implement configs
    "images" => [
        'maxfilesize' => 2000,
        'maxheight' => 800,
        'maxwidth' => 800,
        'quality' => 65,
        'intervention_driver' => 'gd',
        'storage_path' => storage_path('cmsify/images')
    ],

    "categories" => [
        "disabled" => 'huhu',
        "maxLevel" => 2,
    ],

    "tags" => [
        "disabled" => false
    ],

];
