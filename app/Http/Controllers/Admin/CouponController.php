<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    
    public function index() {
     
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request) {
     
        $validatedData = $request->validate([
            'coupon_name' => 'required|unique:coupons|max:255',
            'discount' => 'required|numeric|between:0,100',
        ]);
    
        Coupon::create($validatedData);

        return redirect()->back()->with(toastNotification('Coupon', 'added'));

    }

    public function edit($id) {

        $coupon = Coupon::find($id);

        if (!$coupon) {
            return redirect()->back()->with(toastNotification('Coupon', 'not_found'));
        }

        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update($id, Request $request) {

        $coupon = Coupon::find($id);

        if (!$coupon) {
            return redirect()->route('admin.coupons.index')->with(toastNotification('Coupon', 'not_found'));
        }

        $validatedData = $request->validate([
            'coupon_name' => ['required', 'max:255', Rule::unique('coupons')->ignore($coupon->id)],
            'discount' => 'required|numeric|between:0,100',
        ]);

        $coupon->update($validatedData);

        return redirect()->route('admin.coupons.index')->with(toastNotification('Coupon', 'updated'));

    }
    
    public function destroy($id) {

        $coupon = Coupon::find($id);

        if (!$coupon) {
            return redirect()->back()->with(toastNotification('Coupon', 'not_found'));
        }

        $coupon->delete();

        return redirect()->back()->with(toastNotification('Coupon', 'deleted'));
    }
}
