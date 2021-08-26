<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('can:view roles',    ['only' => ['index', 'show']]);
        $this->middleware('can:create roles',  ['only' => ['create', 'store']]);
        $this->middleware('can:edit roles',    ['only' => ['edit', 'update']]);
        $this->middleware('can:delete roles',  ['only' => ['destroy']]);
    }
    
    public function index() {

        return view('admin.roles.index', ['roles' => Role::with('permissions:id,name')->get()]);
    }

    public function show(Role $role) {
        return view('admin.roles.show', compact('role'));
    }

    public function create() {
        return view('admin.roles.create', ['permissions' => Permission::orderBy('id')->pluck('name', 'id')]);
    }

    public function store(Request $request) {

        $attributes =  $request->validate(['name' => 'required|unique:roles,name', 'permissions' => 'required']);

        $role = Role::create(Arr::except($attributes, 'permissions'));
        $role->givePermissionTo($request->input('permissions'));

        return redirect()->route('admin.roles.index')->with(toastNotification('Role', 'created'));
    }

    public function edit(Role $role) {

        $permissions = Permission::pluck('name', 'id');
        $rolePermissions = $role->getPermissionNames();
    
        return view('admin.roles.edit',compact('role','permissions','rolePermissions'));
    }

    public function update(Request $request, Role $role) {

        $attributes =  $request->validate([
            'name' => ['required',  Rule::unique('roles')->ignore($role)],
            'permissions' => 'required'
        ]);

        $role->update(Arr::except($attributes, 'permissions'));
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('admin.roles.index')->with(toastNotification('Role', 'updated'));
    }

    public function destroy(Role $role) {

        $role->delete();
        return redirect()->route('admin.roles.index')->with(toastNotification('Role', 'deleted'));
    }
}
