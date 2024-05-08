<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\AddToCart;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\AvailableCountry;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserProfilesController extends Controller
{
    public function userDashboard()
    {

        $categories = Category::with('subcategories')->get();
        $orders = Invoice ::where('user_id',auth()->user()->id)->get(); 
        // dd($orders);
        // Fetch all brands
        $cartProducts = null;
        if (auth()->check()) {
            $cartProducts = AddToCart::where('user_id', auth()->id())->with('product')->get();
        }
        $userProfile = UserProfile::where('user_id',auth()->user()->id)->first();
        // dd($userProfile);
        $countries = AvailableCountry::get();
        return view('frontend.pages.user-dashboard', compact('categories','orders', 'userProfile', 'cartProducts', 'countries'));
        // return view('frontend.pages.user-dashboard');
    }

    public function profileCreate(Request $request)
    {
        // dd($request->districts_id);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'country_id' => 'required|exists:available_countries,id',
            'districts_id' => 'required|exists:available_districts,id',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:4|max:255',
            'npassword' => 'nullable|string|min:4|max:255',
            'cpassword' => 'nullable|string|same:npassword',
        ]);

        $userProfile = new UserProfile();
        $userProfile->user_id = auth()->user()->id;
        $userProfile->first_name = $request->first_name;
        $userProfile->last_name = $request->last_name;
        $userProfile->country_id = $request->country_id;
        $userProfile->districts_id = $request->districts_id;
        $userProfile->address_1 = $request->address_1;
        $userProfile->address_2 = $request->address_2;
        $userProfile->city = $request->city;
        $userProfile->post_code = $request->post_code;
        $userProfile->save();

        if ($request->filled('npassword')) {
            if (Hash::check($request->password, auth()->user()->password)) {
                $user = User::find(auth()->id());
                $user->update(['password' => Hash::make($request->npassword)]);
            }
            $notification = ['message' => 'Password not match!', 'alert-type' => 'error'];
            return back()->with($notification);
        }

        $notification = ['message' => 'Profile Updated Succesfully!', 'alert-type' => 'success'];
        return back()->with($notification);
    }
}
