<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CouponStatus;
use App\Model\Admin\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;

class CouponController extends Controller
{
    
    public function index() {
        return view('admin.coupons.index', ['coupons' =>  Coupon::all()]);
    }

    public function store(CouponRequest $request) {
        Coupon::create($request->validated());
        return redirect()->route('admin.coupons.index')->with(toastNotification('Coupon', 'added'));
    }

    public function edit(Coupon $coupon) {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Coupon $coupon, CouponRequest $request) {
        $validated = $request->validated();
        $validated['status'] = $coupon->expired_at->lessThan(now()) ?  'expired' : $validated['status'];
        $coupon->update($validated);
        return redirect()->route('admin.coupons.index')->with(toastNotification('Coupon', 'updated'));
    }
    
    public function destroy(Coupon $coupon) {
        $coupon->delete();
        return redirect()->back()->with(toastNotification('Coupon', 'deleted'));
    }
}