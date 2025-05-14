<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log; // Thêm dòng này để sử dụng Log

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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override the login function to add logging.
     */
    public function signin(Request $request)
    {
        Log::info('Attempting to login with email: ' . $request->email); // Log email khi đăng nhập

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Log::info('User logged in successfully: ' . $request->email);  // Log khi thành công
            return redirect()->intended($this->redirectTo);
        } else {
            Log::warning('Login failed for email: ' . $request->email);  // Log khi thất bại
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }
}
