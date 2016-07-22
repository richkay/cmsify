<?php

return [

    // !TODO: implement configs

    "images" => [
        'maxfilesize' => 2000,
        'maxwidth' => 800,
        'maxheight' => 800,
        'quality' => 65,
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
