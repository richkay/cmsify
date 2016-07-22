<?php

return [

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

        "disabled" => false,
        "maxLevel" => 2,

    ],

    "tags" => [
        "disabled" => false
    ],

];
