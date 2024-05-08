<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function loginPage()
    {
        $categories = Category::with('subcategories')->get();
        return view('frontend.pages.login-page', compact('categories'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // Change 'phone' to 'login'
            'password' => 'required|min:3',
        ]);

        $loginField = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone'; // Check if the input is an email or a phone number

        $credentials = [
            $loginField => $request->input('login'),
            'password' => $request->input('password'),
        ];

        if (!auth()->attempt($credentials, $request->remember)) {
            return back()->with('error', 'Invalid email/phone or password');
        }

        $user = auth()->user();

        // Check if the user's type is not allowed
        if ($user->is_admin != 0) {
            auth()->logout();
            return back()->with('status', 'You are not authorized for this page');
        }

        $notification = ['message' => 'Login Successfully!', 'alert-type' => 'success'];
        return redirect()->route('home')->with($notification);
    }




    public function registrationPage()
    {
        $categories = Category::with('subcategories')->get();
        return view('frontend.pages.registration-page', compact('categories'));
    }

    public function registration(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'phone' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|confirmed'
        ]);

        // If the validation passes, create a new user
        $user = User::create([
            'phone' => $request->phone,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);
        $notification = ['message' => 'Ragistration Successfully!', 'alert-type' => 'success'];
        return redirect()->route('home')->with($notification);
    }

    public function logout()
    {
        Auth::logout();

        $notification = [
            'message' => 'You are logged out',
            'alert-type' => 'success'
        ];

        return redirect()->route('login')->with($notification);
    }
}
