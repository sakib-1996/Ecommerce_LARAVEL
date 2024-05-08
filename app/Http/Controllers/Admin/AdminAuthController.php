<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials, $request->remember)) {
            return back()->with('error', 'Invalid email or password');
        }

        $user = auth()->user();
        if ($user->is_admin != 1) {
            auth()->logout();
            return back()->with('status', 'You are not authorized for this page');
        }
        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();

        $notification = [
            'message' => 'You are logged out',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.login')->with($notification);
    }
}
