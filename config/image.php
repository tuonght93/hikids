<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'images' => array(
        "avatars" => array("40x40","60x60","100x100","200x200"),
        "products" => array("70x70","100x100","200x200","300x300","400x300","800x600"),
        "productCategories" => array("70x70","150x150", "870x217"),
        "brands" => array("70x70","150x150", "300x300"),
        "slides" => array("70x70","150x150", "1140x350"),
        "colors" => array("70x70","150x150", "300x300"),
        "brands" => array("70x70","150x150", "300x300"),
        "pages" => array("70x70")
    ), 
    //'image_root' => 'E:\wamp\www\happyapi\public\uploads\images',
    //'image_url' => 'http://happyapi.local/uploads/images',
    'image_root' => env('IMAGE_ROOT'),
    'image_url' => env('IMAGE_URL'),
    'image_root_admin' => public_path().'/images',
    'image_url_admin' => env('IMAGE_URL_ADMIN'),

);
