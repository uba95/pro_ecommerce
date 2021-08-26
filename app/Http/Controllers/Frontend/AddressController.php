<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index() {
        return view('pages.addresses.index', ['addresses' => current_user()->addresses]);
    }

    public function create() {
        return view('pages.addresses.create', ['countries' => Country::get(['id', 'name'])]);
    }

    public function store(AddressRequest $request) {
        current_user()->addresses()->create($request->validated());
        return redirect()->route('addresses.index')->with(toastNotification('Address', 'created'));
    }

    public function edit(Address $address) {
        $this->authorize('change', $address);
        return view('pages.addresses.edit', [
            'address' => $address,
            'countries' => Country::get(['id', 'name']),
        ]);
    }
    
    public function update(Address $address, AddressRequest $request) {
        $this->authorize('change', $address);
        $address->update(array_merge($request->validated(), ['user_id' => Auth::id()]));
        return redirect()->route('addresses.index')->with(toastNotification('Address', 'updated'));
    }

    public function destroy(Address $address) {
        $this->authorize('change', $address);
        $address->delete();
        return redirect()->route('addresses.index')->with(toastNotification('Address', 'deleted'));
    }
}