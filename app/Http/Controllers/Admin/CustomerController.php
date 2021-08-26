<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct() {
        $this->middleware('can:view customers',    ['only' => ['index', 'show']]);
        $this->middleware('can:delete customers',  ['only' => ['destroy']]);
    }

    public function index() {
        return view('admin.customers.index', ['customers' => User::all()]);
    }

    public function show(User $customer) {

        return view('admin.customers.show', compact('customer'));
    }

    public function destroy(User $customer) {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with(toastNotification('Customer', 'deleted'));
    }
}
