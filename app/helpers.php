<?php

use Intervention\Image\Facades\Image;

function img_upload($image) {

    $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    Image::make($image)->resize(300,300)->save(storage_path('app/public/media/products/'.$image_name));
    return $image_name;
}

function toastNotification($entitty, $message = 'empty') {

    $notifications = [
        'not_found' => [
            'messege'=>"$entitty Not Found",
            'alert-type'=>'error'
        ],

        'added' => [
            'messege'=>"New $entitty Added Successfully",
            'alert-type'=>'success'
        ],

        'updated' => [            
            'messege'=>"$entitty Updated Successfully",
            'alert-type'=>'success'
        ],
        
        'deleted' => [            
            'messege'=>"$entitty Deleted Successfully",
            'alert-type'=>'success'
        ],
        'empty' => [            
            'messege'=>"$entitty",
            'alert-type'=>'success'
        ],
    ];

    return $notifications[$message];
}