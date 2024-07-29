<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Determine where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        // Check the user's role and set the redirect path accordingly
        if ($user->role == 'admin') {
            return '/admin/dashboard'; // Redirect admins to admin dashboard
        } elseif ($user->role == 'driver') {
            return '/driver/dashboard'; // Redirect drivers to driver dashboard
        } elseif ($user->role == 'customer') {
            return '/pickup-requests/schedule'; // Redirect customers to their home
        } else {
            return '/home'; // Default redirect if role is not recognized
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}


