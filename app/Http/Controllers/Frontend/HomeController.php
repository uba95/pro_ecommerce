<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.edit');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function update(EditUserRequest $request) {

      $user = User::findOrFail(current_user()->id);
      $attributes = $request->validated();
      
      if ($request->hasFile('avatar')) {
        // delete old avatar & upload the new one
        Storage::disk('public')->delete($user->getOriginal('avatar'));
        $attributes['avatar'] = img_upload($request->file('avatar'), 'media/users/avatars/', true);
      }
      
      $user->update($attributes);
  
      return redirect()->route('home')->with(toastNotification('Account', 'updated'));
    }

    public function password() {

      return view('auth.password');
    }

    public function updatePassword(Request $request) {
  
      $user = User::findOrFail(Auth::id());

      $attributes = $request->validate([
        'oldpass' => ['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed']
      ]);
  
      if (!Hash::check($request->oldpass, $user->password)) {
        return back()->with(toastNotification('Old Password Not Matched', 'error'));
      }
  
      $user->update($attributes);
  
      return redirect()->route('home')->with(toastNotification('Password Updated Successfully'));
    }

}
