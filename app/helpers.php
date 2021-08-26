<?php

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

function calculateTotalPrice(float $price, int $quantity) : float {
    return  round($price *  $quantity, 2);
}

function  snakeToTitle($value){

    return str_replace('_', ' ', Str::title($value));
}

function  camelToTitle($value){

    return ucwords(implode(' ', preg_split('/(?=[A-Z])/', $value)));
}

function  productSelectScope( $q){

    return $q -> select('products.id','brand_id', 'product_name', 'product_quantity', 'selling_price', 'discount_price', 'main_slider', 'hot_deal', 'best_rated', 'mid_slider', 'hot_new', 'trend', 'cover', 'status');
}

function isAdmin() {

    return Auth::guard('admin')->check();
}

function current_user(){

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

function img_upload($image, $path = 'media/products/images/', $resize = false) {

    $image_name = $path . hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

    if ($resize) {
        Image::make($image)->resize(300,300)->save(storage_path("app/public/".$image_name));
        return $image_name;
    }

    Image::make($image)->save(storage_path("app/public/".$image_name));
    return $image_name;
}

function toastNotification($message, $type = 'success') {

    $notifications = [
        'not_found' => [
            'message'=>"$message Not Found",
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