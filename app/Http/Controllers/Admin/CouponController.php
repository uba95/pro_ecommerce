<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\MethodsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class CouponController extends ParentController
{
    use MethodsTrait;

    public static function method($method, $id=null) {
     
        switch ($method) {
            case 'index':
                return array_values([
                    'models' => [Coupon::all()],
                    'names' => ["coupons"],
                    'path' => 'admin.coupons.index',
                    'data' => [],
                ]);
                break;

            case 'store':
                return array_values([
                    'models' => [Coupon::class],
                    'names' => ["Coupon"],
                    'path' => '',
                    'data' => [[
                        'coupon_name' => 'required|unique:coupons|max:255',
                        'discount' => 'required|numeric|between:0,100',
                    ]],
                ]);
                break;
            
            case 'edit':
                return array_values([
                    'models' => [Coupon::findOrFail($id)],
                    'names' => ["coupon"],
                    'path' => 'admin.coupons.edit',
                    'data' => [],
                ]);
                break;
            
            case 'update':
                return array_values([
                    'models' => [Coupon::findOrFail($id)],
                    'names' => ["Coupon"],
                    'path' => 'admin.coupons.index',
                    'data' => [[
                        'coupon_name' => ['required', 'max:255', Rule::unique('coupons')->ignore($id)],
                        'discount' => 'required|numeric|between:0,100',
                    ]],
                ]);
                break;
            
            case 'destroy':
                return array_values([
                    'models' => [Coupon::findOrFail($id)],
                    'names' => ["Coupon"],
                    'path' => '',
                    'data' => [],
                ]);               
                break;
        }
    }
}
