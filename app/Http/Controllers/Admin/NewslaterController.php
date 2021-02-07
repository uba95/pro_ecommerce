<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Newslater;
use App\Http\Controllers\MethodsTrait;

class NewslaterController extends ParentController
{
    
    use MethodsTrait;

    public static function method($method, $id=null) {
     
        switch ($method) {
            case 'index':
                return array_values([
                    'models' => [Newslater::all()],
                    'names' => ["newslaters"],
                    'path' => 'admin.newslater',
                    'data' => [],
                ]);
                break;

            case 'store':
                return array_values([
                    'models' => [Newslater::class],
                    'names' => ["Thanks For Subscribing!"],
                    'path' => '',
                    'data' => [[
                        'email' => 'required|unique:newslaters|max:255',
                    ]],
                ]);
                break;
                        
            case 'destroy':
                return array_values([
                    'models' => [Newslater::findOrFail($id)],
                    'names' => ["Newslater"],
                    'path' => '',
                    'data' => [],
                ]);               
                break;
        }
    }
}
