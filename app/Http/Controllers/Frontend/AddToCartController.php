<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\AddToCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AvailableCountry;
use App\Models\AvailableDistrict;
use App\Models\UserProfile;

class AddToCartController extends Controller
{
    public function addToCart(Request $request)
    {
        // dd($request->all());
        if (auth()->user()->is_admin != 0) {
            return back();
        }
        // dd($request->all());
        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $addToCart = AddToCart::where('product_id', $request->product_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($addToCart) {
            // dd('no data');
            $addToCart->update([
                'quantity' => $request->quantity,
            ]);
        } else {
            // dd('data');
            AddToCart::create([
                'product_id' => $request->product_id,
                'user_id' => auth()->id(),
                'quantity' => $request->quantity,
            ]);
        }

        $notification = ['message' => 'Product Added Successfully!', 'alert-type' => 'success'];
        return back()->with($notification);
    }

    public function viewCart()
    {
        // if (auth()->user()->is_admin != 0) {
        //     return back();
        // }
        $categories = Category::with('subcategories')->get();
        // Fetch all brands
        $brands = Brand::get();
        $cartProducts = null;
        if (auth()->check()) {
            $cartProducts = AddToCart::where('user_id', auth()->id())->with('product')->get();
        }
        $countries = AvailableCountry::get();
        return view('frontend.pages.viewCart-page', compact('categories', 'brands', 'cartProducts', 'countries'));
    }

    public function updateCart(Request $request)
    {
        // dd($request->all());
        if (!auth()->user()) {
            $notification = ['message' => 'Login first!', 'alert-type' => 'success'];
            return redirect()->route('login')->with($notification);
        }
        if (!$request->product_id) {
            $notification = ['message' => 'No Product in your cart!', 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        if (auth()->user()->is_admin != 0) {
            return back();
        }

        foreach ($request->product_id as $key => $product_id) {
            // Check if the corresponding quantity exists
            if (isset($request->quantity[$key])) {
                $quantity = $request->quantity[$key];
                // echo $quantity . '-' . $product_id . '/';
                $cart = AddToCart::where('user_id', auth()->user()->id)
                    ->where('product_id', $product_id)
                    ->first();
                $cart->update(['quantity' => $quantity]);
            }
        }
        $userProfile = UserProfile::where('user_id', auth()->user()->id)->first();
        if (!$userProfile) {
            $notification = ['message' => 'Fisrt You have to create profile!', 'alert-type' => 'warning'];
            return redirect()->route('userDashboard')->with($notification);
        }

        $notification = ['message' => 'Product Added Successfully!', 'alert-type' => 'success'];
        return redirect()->route('checkOut')->with($notification);
    }





    public function availabledistrict($countryId)
    {
        $districts = AvailableDistrict::Where('country_id', $countryId)->get();
        return response()->json([
            'status' => true,
            'data' => $districts,

        ]);
    }

    public function removeCartItem($itenId)
    {
        // dd($itenId);
        $cartItem = AddToCart::findOrFail($itenId);
        $cartItem->delete();
        $notification = ['message' => 'Cart Item Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}
