<?php

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

function  productSelectScope( $q){

    return $q -> select('products.id','brand_id', 'product_name', 'product_quantity', 'selling_price', 'discount_price', 'main_slider', 'hot_deal', 'best_rated', 'mid_slider', 'hot_new', 'trend', 'image_one', 'status');
}

function isAdmin() {

    return Auth::guard('admin')->check();
}

function img_upload($image) {

    $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    Image::make($image)->resize(300,300)->save(storage_path('app/public/media/products/'.$image_name));
    return $image_name;
}

function toastNotification($entitty, $message = 'empty') {

    $notifications = [
        'not_found' => [
            'message'=>"$entitty Not Found",
            'alert-type'=>'error'
        ],

        'added' => [
            'message'=>"New $entitty Added Successfully",
            'alert-type'=>'success'
        ],

        'updated' => [            
            'message'=>"$entitty Updated Successfully",
            'alert-type'=>'success'
        ],
        
        'deleted' => [            
            'message'=>"$entitty Deleted Successfully",
            'alert-type'=>'success'
        ],
        'empty' => [            
            'message'=>"$entitty",
            'alert-type'=>'success'
        ],
    ];

    return $notifications[$message];
}