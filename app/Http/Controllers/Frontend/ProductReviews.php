<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviews extends Controller
{
    public function productReview(Request $request)
    {
        // Validate the request data
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:255',
            'product_id' => 'required',
        ]);

        if (!auth()->user()) {
            return redirect()->route('login');
        }

        ProductReview::create([
            'user_id' => auth()->user()->id,
            'product_id' => $request->input('product_id'),
            'review' => $request->input('message'),
            'rating' => $request->input('rating'),

        ]);

        return redirect()->back();
    }

    public function deletReview($reviewId)
    {
        ProductReview::find($reviewId)->delete();
        return redirect()->back();
    }
}
