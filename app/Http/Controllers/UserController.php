<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'active' => 1
        ];

        $remember = false;
        if ($request->input('remember')) {
            $remember = true;
        }

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('dashboard');
        }

        flash('Cannot login. Check your username and password again', 'danger');
        return redirect()->back();
    }
    
    public function postLogout(Request $request)
    {
        Auth::logout();
        flash('You have been logged out');
        return redirect('/');
    }

    public function pageDashboard()
    {
        $dashboardData['activation_pending'] = 2;
        $dashboardData['my_recent_activities']  = 10;
        return view('adminlte.pages.dashboard',compact('dashboardData'));
    }
    
    /**
     * Get the User's profile page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageUserProfile()
    {
        return view('adminlte.pages.user-profile');
    }
}
