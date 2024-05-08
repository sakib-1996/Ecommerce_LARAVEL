<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Category;
use App\Models\AddToCart;
use App\Models\ProductQty;
use App\Models\ProductWish;
use Illuminate\Http\Request;
use App\Models\AvailableCountry;
use App\Http\Controllers\Controller;

class ProductWishController extends Controller
{
    public function addToWish($productId)
    {
        // Check if the user is not logged in
        if (!auth()->user()) {
            $notification = ['message' => 'Login first!', 'alert-type' => 'success'];
            return redirect()->route('login')->with($notification);
        }

        // Check if the user is an admin
        if (auth()->user()->is_admin != 0) {
            $notification = ['message' => 'Admin cannot add product!', 'alert-type' => 'success'];
            return back()->with($notification);
        }

        // Check if the product already exists in the user's wishlist
        $wishlistEntry = ProductWish::where('product_id', $productId)
            ->where('user_id', auth()->id())
            ->first();

        // If the product doesn't exist in the wishlist, create a new entry
        if ($wishlistEntry === null) {
            ProductWish::create([
                'product_id' => $productId,
                'user_id' => auth()->id(),
            ]);
        }

        // Prepare a success notification message
        $notification = ['message' => 'Product Added Successfully!', 'alert-type' => 'success'];

        // Redirect back to the previous page with the success notification
        return back()->with($notification);
    }

    public function wishlist()
    {

        
        $categories = Category::with('subcategories')->get();
        // Fetch all brands
        $brands = Brand::get();
        $cartProducts = null;
        if (auth()->check()) {
            $cartProducts = AddToCart::where('user_id', auth()->id())->with('product')->get();
        }
        $wishList = ProductWish::where('user_id', auth()->user()->id)->with('product')->get();
        $countries = AvailableCountry::get();
        return view('frontend.pages.wishList-page', compact('categories', 'wishList', 'brands', 'cartProducts', 'countries'));
    }

    public function removeWishlist($itemId)
    {
        
        $withItem = ProductWish::findOrFail($itemId);
        // dd($withItem);
        $withItem->delete();
        $notification = ['message' => 'Wish Item Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}
