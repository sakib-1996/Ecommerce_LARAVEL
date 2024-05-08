<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\AddToCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;

class FrontendHomeController extends Controller
{
    public function homePage()
    {
        $categories = Category::with('subcategories')->get();
        $products = Product::with('productQtys', 'category')->get();
        $brands = Brand::get();

        $cartProducts = null;
        if (auth()->check()) {
            $cartProducts = AddToCart::where('user_id', auth()->id())->with('product')->get();
        }

        return view('frontend.pages.home-page', compact('categories','cartProducts', 'products', 'brands'));
    }

    public function productByCatId($catId)
    {
        $products = Product::where('cat_id', $catId)
            ->with('productQtys', 'category')
            ->paginate(10);

        $categories = Category::with('subcategories')->get();
        $brands = Brand::get();
        
        $cartProducts = null;
        if (auth()->check()) {
            $cartProducts = AddToCart::where('user_id', auth()->id())->with('product')->get();
        }
        return view('frontend.pages.product-by-category', compact('categories','cartProducts', 'products', 'brands'));
    }

    public function productBySubCatId($subCatId)
    {
        $products = Product::where('subCat_id', $subCatId)
            ->with('productQtys', 'category')
            ->paginate(10);

        $categories = Category::with('subcategories')->get();

        $brands = Brand::get();

        
        $cartProducts = null;
        if (auth()->check()) {
            $cartProducts = AddToCart::where('user_id', auth()->id())->with('product')->get();
        }

        return view('frontend.pages.product-by-category', compact('categories','cartProducts', 'products', 'brands'));
    }

    public function productById($productId)
    {
        // Fetch the product with the given ID, along with related data including product images
        $product = Product::where('id', $productId)
            ->with('productQtys', 'category', 'subCategory', 'childCategory', 'productImgs','discounts') // Include the productImgs relationship
            ->first();
            if($product== null){
                return redirect()->route('home');
            }
        // dd($product->discounts);
        if ($product->druft === 0) {
            // dd($product);
            $notification = array('message' => 'Product Not found!', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }
        // dd($product);
        //    dd($product->related_product);
        // Fetch all categories along with their subcategories
        $categories = Category::with('subcategories')->get();

        $reviews = ProductReview::where('product_id', $productId)->with('user.profile')->get();

        // dd($reviews);
        // Fetch all brands
        $brands = Brand::get();
        $cartProducts = null;
        if (auth()->check()) {
            $cartProducts = AddToCart::where('user_id', auth()->id())->with('product')->get();
        }
        // dd($cartProducts);
        return view('frontend.pages.details-page', compact('categories','reviews', 'product', 'brands','cartProducts'));
    }
}
