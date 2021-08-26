<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('can:view permissions',    ['only' => ['index']]);
        $this->middleware('can:create permissions',  ['only' => ['store']]);
        $this->middleware('can:edit permissions',    ['only' => ['edit', 'update']]);
        $this->middleware('can:delete permissions',  ['only' => ['destroy']]);
    }

    public function index() {
        return view('admin.permissions.index', ['permissions' => Permission::all()]);
    }

    public function store(Request $request) { 
        $attributes = $request->validate(['name' => 'required|unique:permissions']);
        Permission::create($attributes);
        return redirect()->back()->with(toastNotification('Permission', 'created'));
    }

    public function edit(Permission $permission) {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Permission $permission, Request $request) {
        $attributes = $request->validate([
            'name' => ['required', Rule::unique('permissions')->ignore($permission->id)],
        ]);
        $permission->update($attributes);
        return redirect()->route('admin.permissions.index')->with(toastNotification('Permission', 'updated'));
    }
    
    public function destroy(Permission $permission) {
        $permission->delete();
        return redirect()->back()->with(toastNotification('Permission', 'deleted'));
    }
}
