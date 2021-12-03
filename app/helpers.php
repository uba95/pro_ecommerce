<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

function checkArrayElementsAreUnique($array)  {
    return count($array) === count(array_flip($array));
}

function debugInfo($data)  {
    return Barryvdh\Debugbar\Facade::info($data);
}

function getDiscountPercent($selling_price,  $discount_price)  {
    return (($selling_price - $discount_price) / $selling_price) * 100;
}

function priceAfterDiscount($selling_price,  $percent, $intval = false)  {
    $price = $selling_price - ($selling_price * $percent / 100);
    return $intval ? intval($price) : number_format($price, 2);
}

function discountPrice($price,  $percent)  {
    $price = ($price * $percent / 100);
    return number_format($price, 2);
}

function calculateTotalPrice(float $price, int $quantity) : float {
    return  round($price *  $quantity, 2);
}

function  snakeToTitle($value){

    return str_replace('_', ' ', Str::title($value));
}

function  camelToTitle($value){

    return substr(ucwords(implode(' ', preg_split('/(?=[A-Z])/', $value))), 1);
}

function isAdmin() {

    return Auth::guard('admin')->check();
}

function current_user() {

    return Auth::guard('web')->user();
}

// function img_products_upload($image, $cover = false) {

//     $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
//     if ($cover) {
//         Image::make($image)->resize(300,300)->save(storage_path("app/public/media/products/covers/".$image_name));
//         return $image_name;
//     }
//     Image::make($image)->save(storage_path("app/public/media/products/images/".$image_name));
//     return $image_name;
// }

function img_upload($image, $path, $resize = false) {

    $image_name = $path . hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    $storage_path = storage_path("app/public/".$image_name);

    if ($resize) {
        Image::make($image)->resize(150,150)->save($storage_path);
    } else {
        Image::make($image)->save($storage_path);
    }

    return $image_name;
}

function toastNotification($message, $type = 'success') {

    $notifications = [
        'not_found' => [
            'message'=>"$message Is Not Found",
            'alert-type'=>'error'
        ],

        'created' => [
            'message'=>"New $message Has Been Successfully Created",
            'alert-type'=>'success'
        ],

        'updated' => [            
            'message'=>"$message Has Been Successfully Updated",
            'alert-type'=>'success'
        ],
        
        'deleted' => [            
            'message'=>"$message Has Been Successfully Deleted",
            'alert-type'=>'success'
        ],
        'success' => [            
            'message'=>"$message",
            'alert-type'=>'success'
        ],
        'error' => [            
            'message'=>"$message",
            'alert-type'=>'error'
        ],
    ];

    return $notifications[$type];
}