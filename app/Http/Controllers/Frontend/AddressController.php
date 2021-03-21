<?php

namespace App\Http\Controllers\Frontend;

use App\Model\Address;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MethodsTrait;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Requests\AddressRequest;
use App\Model\Country;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    public function index() {
        return view('pages.addresses.index', ['addresses' => Auth::user()->addresses]);
    }

    public function create() {
        return view('pages.addresses.create', ['countries' => Country::get(['id', 'name'])]);
    }

    public function store(AddressRequest $request) {
     
        Address::create(array_merge($request->validated(), ['user_id' => Auth::id()]));
        return redirect()->route('addresses.index')->with(toastNotification('Address', 'added'));
    }

    public function edit(Address $address) {
        
        return view('pages.addresses.edit', [
            'address' => $address,
            'countries' => Country::get(['id', 'name']),
        ]);
    }
    
    public function update(Address $address, AddressRequest $request) {
        
        $address->update(array_merge($request->validated(), ['user_id' => Auth::id()]));
        return redirect()->route('addresses.index')->with(toastNotification('Address', 'updated'));
    }

    public function destroy(Address $address) {
        
        $address->delete();
        return redirect()->route('addresses.index')->with(toastNotification('Address', 'deleted'));
    }

}



    // use MethodsTrait;

    // public static function method($method, $id=null) {
     
    //     switch ($method) {
    //         case 'index':
    //             return array_values([
    //                 'models' => [Address::all()],
    //                 'names' => ["addresses"],
    //                 'path' => 'admin.addresses.index',
    //                 'data' => [],
    //             ]);
    //             break;

    //         case 'store':
    //             return array_values([
    //                 'models' => [Address::class],
    //                 'names' => ["Address"],
    //                 'path' => '',
    //                 'data' => [[
    //                     // 'address_name' => 'required|unique:addresses|max:255',
    //                     // 'discount' => 'required|numeric|between:0,100',
    //                 ]],
    //             ]);
    //             break;
            
    //         case 'edit':
    //             return array_values([
    //                 'models' => [Address::findOrFail($id)],
    //                 'names' => ["address"],
    //                 'path' => 'admin.addresses.edit',
    //                 'data' => [],
    //             ]);
    //             break;
            
    //         case 'update':
    //             return array_values([
    //                 'models' => [Address::findOrFail($id)],
    //                 'names' => ["Address"],
    //                 'path' => 'admin.addresses.index',
    //                 'data' => [[
    //                     // 'address_name' => ['required', 'max:255', Rule::unique('addresses')->ignore($id)],
    //                     // 'discount' => 'required|numeric|between:0,100',
    //                 ]],
    //             ]);
    //             break;
            
    //         case 'destroy':
    //             return array_values([
    //                 'models' => [Address::findOrFail($id)],
    //                 'names' => ["Address"],
    //                 'path' => '',
    //                 'data' => [],
    //             ]);               
    //             break;
    //     }
    // }
