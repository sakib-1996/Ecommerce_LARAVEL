<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function disIndex($productId)
    {
        $discounts = Discount::where('product_id', $productId)->get();
        $product = Product::find($productId);
        return view('admin.pages.discount.index', compact('discounts', 'product'));
    }

    public function addDis(Request $request, $productId)
    {
        // dd($request->all());
        $rules = [
            'dis_title' => 'required|string|max:255',
            'dis_rate' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'run_time' => 'nullable|integer|min:1',
            'details' => 'nullable|string',
        ];

        $validatorMessages = [
            'dis_title.required' => 'The discount title is required.',
            'dis_title.max' => 'The discount title must not exceed 255 characters.',
            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'The start time must be in the format HH:MM.',
            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'The end time must be in the format HH:MM.',
            'run_time.integer' => 'The run time must be an integer.',
            'run_time.min' => 'The run time must be at least :min.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessages);

        if ($validator->fails()) {
            $errorMessage = implode('', $validator->errors()->all());
            $notification = ['message' => $errorMessage, 'alert-type' => 'error'];
            return redirect()->back()->with($notification)->withInput();
        }


        $discount = new Discount;
        $discount->dis_title = $request->input('dis_title');
        $discount->dis_rate = $request->input('dis_rate');
        $discount->start_date = $request->input('start_date') . ' ' . $request->input('start_time');
        $discount->end_date = $request->input('end_date') . ' ' . $request->input('end_time');
        $discount->run_time = $request->input('run_time');
        $discount->dis_details = $request->input('details');
        $discount->product_id = $productId;
        $discount->save();

        $notification = array('message' => 'New Discount Added!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function DeleteDis($disId)
    {
        // dd($disId);
        Discount::find($disId)->delete();
        $notification = ['message' => 'Discount Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }


    //edit method
    public function editDiscount($disId)
    {
        $data = Discount::findorfail($disId);
        return response()->json($data);
    }
    
    public function updateDiscount(Request $request)
    {

        $discountId = $request->input('id');

        // dd($request->all());
        $rules = [
            'dis_title' => 'required|string|max:255',
            'dis_rate' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'run_time' => 'nullable|integer|min:1',
            'details' => 'nullable|string',
        ];

        $validatorMessages = [
            'dis_title.required' => 'The discount title is required.',
            'dis_rate.required' => 'The discount rate is required.',
            'dis_title.max' => 'The discount title must not exceed 255 characters.',
            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'The start time must be in the format HH:MM.',
            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'The end time must be in the format HH:MM.',
            'run_time.integer' => 'The run time must be an integer.',
            'run_time.min' => 'The run time must be at least :min.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessages);
        if ($validator->fails()) {
            $errorMessage = implode('', $validator->errors()->all());
            $notification = ['message' => $errorMessage, 'alert-type' => 'error'];
            return redirect()->back()->with($notification)->withInput();
        }

        $discount = Discount::findOrFail($discountId);

        $discount->update([
            'dis_title' => $request->input('dis_title'),
            'dis_rate' => $request->input('dis_rate'),
            'start_date' => $request->input('start_date') . ' ' . $request->input('start_time'),
            'end_date' => $request->input('end_date') . ' ' . $request->input('end_time'),
            'run_time' => $request->input('run_time'),
            'dis_details' => $request->input('details'),
        ]);

        $notification = ['message' => 'Discount Updated Successfully!', 'alert-type' => 'success']; // Corrected typo in message
        return redirect()->back()->with($notification);
    }

    public function discountStatusUpdate($disId)
    {
        // dd($disId);
        $disStatus = Discount::findOrFail($disId);
        $newStatus = $disStatus->status == 0 ? 1 : 0;
        // dd($newStatus);
        $disStatus->update(['status' => $newStatus]);
        return back();
    }
}
