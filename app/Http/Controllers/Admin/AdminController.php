<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
  public function __construct() {
    $this->middleware('can:view admins',    ['only' => ['index', 'show']]);
    $this->middleware('can:create admins',  ['only' => ['create', 'store']]);
  }
  
  public function index() {
    return view('admin.admins.index', ['admins' => Admin::with('roles:id,name')->get()]);
  }

  public function show(Admin $admin) {
    return view('admin.admins.show', compact('admin')); 
  }

  public function create() {
    
    // only super admin can create admin with super admin role
    $roles = RoleService::filter(Auth::user(), Role::orderBy('id')->pluck('name'))->get();
    return view('admin.admins.create', compact('roles'));
  }

  public function store(AdminRequest $request) {

    $attributes = $request->validated();

    if ($request->hasFile('avatar')) {
      $attributes['avatar'] = img_upload($request->file('avatar'), Admin::AVATARS_STOREAGE, true);
    }

    $admin = Admin::create(Arr::except($attributes, 'roles'));
    RoleService::filter(Auth::user(), collect($request->input('roles')))->assignTo($admin);

    return redirect()->route('admin.admins.index')->with(toastNotification('Admin', 'created'));
  }

  public function edit(Admin $admin) {

    $this->authorize('edit', $admin);

    $roles = RoleService::filter(Auth::user(), Role::orderBy('id')->pluck('name'))->get();
    $adminRoles = $admin->getRoleNames();

    return view('admin.admins.edit', compact('admin', 'roles', 'adminRoles'));
  }

  public function update(AdminRequest $request, Admin $admin) {

    $this->authorize('edit', $admin);
    
    $attributes = $request->validated();

    if ($request->hasFile('avatar')) {
      // delete old avatar & upload the new one
      Storage::disk('public')->delete($admin->getOriginal('avatar'));
      $attributes['avatar'] = img_upload($request->file('avatar'), Admin::AVATARS_STOREAGE, true);
    }

    $admin->update(Arr::except($attributes, 'roles'));
    RoleService::filter(Auth::user(), collect($request->input('roles')))->assignTo($admin);

    return redirect()->route('admin.admins.index')->with(toastNotification('Admin', 'updated'));
  }

  public function updatePassword(Request $request, Admin $admin) {

    $this->authorize('edit', $admin);

    $attributes = $request->validate([
      'oldpass' => ['required'],
      'password' => ['required', 'string', 'min:8', 'confirmed']
    ]);

    if (!Hash::check($request->oldpass, $admin->password)) {
      return back()->with(toastNotification('Old Password Not Matched', 'error'));
    }

    $admin->update($attributes);

    return redirect()->route('admin.home')->with(toastNotification('Password Updated Successfully'));
  }

  public function destroy(Admin $admin) {

    $this->authorize('delete', $admin);

    Storage::disk('public')->delete($admin->getOriginal('avatar'));
    $admin->delete();
    
    return redirect()->route('admin.admins.index')->with(toastNotification('Admin', 'deleted'));
  }
}
