<?php

return [

    // !TODO: specify middleware and base route name (cmsify) here
    "routing" => [
        'prefix' => 'cmsify',
        'middleware' => null // 'auth',
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

    "permissions" => [
        'onlyCreatorCanEdit' => false,
        'onlyCreatorCanDelete' => false,
    ],

    // !TODO: its just for dev purpose, must delete or replace with some useful relation

    /**
     * If you want to relate data in a many-many or one-one relation.
     * Than create a own model that extends the Cmsify\Post class,
     * specify the class an its relations like the example below
     */
    //    "models" => [
    //        "post" => [
    //            "class" => App\Post::class,
    //            "relations" => [
    //                'locations' => [
    //                    'label' => 'Locations',
    //                    'multiple' => true,
    //                ]
    //            ]
    //        ]
    //    ],

];
