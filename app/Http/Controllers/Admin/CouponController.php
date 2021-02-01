<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CouponController extends ParentController
{
    
    public function index() {
     
        return (new ParentController([Coupon::all()], ["coupons"], 'admin.coupons.index'))->index();
    }

    public function store(Request $request) {
     
        $data = [[
            'coupon_name' => 'required|unique:coupons|max:255',
            'discount' => 'required|numeric|between:0,100',
        ]];

        return (new ParentController([Coupon::class], "Coupon", '', $data))->store($request);
    }

    public function edit($id) {

        return (new ParentController([Coupon::find($id)], ["coupon"], 'admin.coupons.edit'))->edit($id);
    }

    public function update(Request $request, $id) {

        $data = [[
            'coupon_name' => ['required', 'max:255', Rule::unique('coupons')->ignore($id)],
            'discount' => 'required|numeric|between:0,100',
        ]];

        return (new ParentController([Coupon::class], "Coupon", 'admin.coupons.index', $data))->update($request, $id);
    }
    
    public function destroy($id) {

        return (new ParentController([Coupon::class], "Coupon"))->destroy($id);
    }
}
