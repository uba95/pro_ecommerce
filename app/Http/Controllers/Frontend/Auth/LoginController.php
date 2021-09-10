<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest:web')->except('logout');
    }

    protected function loggedOut(Request $request) {
        return redirect($this->redirectTo);
    }

    protected function guard() {
        return Auth::guard('web');
    }

    protected function credentials(Request $request) {

        $value = $request->get('email');
        $field = filter_var($value, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        return [$field => $value, 'password' => $request->get('password')];
    }

    public function redirectService($service) {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callbackService($service) {

        $getUser = Socialite::driver($service)->stateless()->user();
        $user = User::where($service.'_id', $getUser->getId())->first();

        if (!$user) {
            $user = tap(User::create([
                $service.'_id' => $getUser->getId(),
                'name' => $getUser->getName(),
                'email' => $getUser->getEmail(),
                'avatar' => $getUser->getAvatar(),
            ]))->sendEmailVerificationNotification();
        }

        Auth::guard('web')->login($user);
        return redirect($this->redirectTo);
    }
}
