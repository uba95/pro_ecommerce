<?php

namespace App\Http\Controllers;

use App\Model\Admin\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ParentController;

trait MethodsTrait 
{
    
    public static function callMethod($request = null, $id = null) {

        $methodName = Route::getCurrentRoute()->getActionMethod();
        return (new ParentController(...self::method($methodName, $id)))->$methodName(...array_filter([$request, $id]));
    }

    public function index() {

        return self::callMethod();
    }

    public function store(Request $request) {
     
        return self::callMethod($request);
    }

    public function edit($id) {

        return self::callMethod(null, $id);
    }

    public function update(Request $request, $id) {

        return self::callMethod($request, $id);
    }
    
    public function destroy($id) {

        return self::callMethod(null, $id);
    }
}
