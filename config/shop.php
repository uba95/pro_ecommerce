<?php

return [
    'shipping_token' => env('SHIPPING_API_TOKEN'),
    'email'     => env('SHOP_EMAIL', 'john@doe.com'),
    'phone'     => env('SHOP_PHONE', '1 855 791 4041'),
    'address'   => env('SHOP_ADDRESS', '81580 Mariano Vista Lake Trent, VA 41460'),
    'facebook'  => env('SHOP_FACEBOOK', 'facebook.com'),
    'twitter'   => env('SHOP_TWITTER', 'twitter.com'),
    'youtube'   => env('SHOP_YOUTUBE', 'youtube.com'),
    'instagram' => env('SHOP_INSTAGRAM', 'instagram.com'),
    'warehouse' => [
        'address_1' => env('WAREHOUSE_ADDRESS_1', '1600 Amphitheatre Parkway'),
        'address_2' => env('WAREHOUSE_ADDRESS_2', ''),
        'zip'       => env('WAREHOUSE_ZIP', '94043'),
        'city'      => env('WAREHOUSE_CITY', 'Mountain View'),
        'state'     => env('WAREHOUSE_STATE', 'CA'),
        'country'   => env('WAREHOUSE_COUNTRY', 'US'),
        'phone'     => env('WAREHOUSE_PHONE', '1312394043'),
        'email'     => env('WAREHOUSE_EMAIL', 'john1@doe.com'),
    ]
];

