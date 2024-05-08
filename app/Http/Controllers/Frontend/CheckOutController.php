<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\Brand;
use App\Models\Invoice;
use App\Models\Category;
use App\Models\AddToCart;
use App\Helper\SSLCommerz;
use App\Models\ProductQty;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use App\Models\AvailableCountry;
use App\Models\AvailableDistrict;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Discount;

class CheckOutController extends Controller
{
    public function checkOutPage()
    {
        $categories = Category::with('subcategories')->get();

        $cartProducts = null;
        if (auth()->check()) {
            // dd("hello");
            $cartProducts = AddToCart::where('user_id', auth()->id())->with('product')->get();
            if ($cartProducts == null) {
                return redirect()->route('home');
            }
        }

        // Fetch available countries
        $countries = AvailableCountry::get();

        $userProfile = null;
        if (auth()->check()) {
            $userProfile = UserProfile::where('user_id', auth()->user()->id)->first();
        }
        return view('frontend.pages.check-out-page', compact('categories', 'cartProducts', 'userProfile', 'countries'));
    }



    public function InvoiceCreate(Request $request)
    {

        DB::beginTransaction();
        try {
            // Get user details
            $user_id = auth()->user()->id;
            $user_email = auth()->user()->email;
            $cus_phone = auth()->user()->phone;

            // Generate unique transaction ID
            $tran_id = uniqid();
            $delivery_status = 'Pending';
            $payment_status = 'Pending';

            // Get user profile details
            $profile = UserProfile::where('user_id', $user_id)->with('country')->first();
            // dd($profile->country->country_name);
            $cus_details = "Name: $profile->first_name $profile->last_name, Address: $profile->address_1, City: $profile->city $profile->post_code, Phone: $cus_phone";

            $cartProducts = AddToCart::where('user_id', $user_id)->with('product')->get();
            // dd($cartProducts[0]);
            // Determine shipping details
            $ship_details = null;
            if ($request->checkbox != null) {
                $ship_details = "Name: $request->first_name2 $request->last_name2, Address: $request->e_address_1, City: $request->city2 $request->postcode_2, Phone: $request->phone_2";
            }

            $cartProducts = AddToCart::where('user_id', $user_id)->with('product')->get();
            $discountAmount = 0; // Initialize discount amount to 0

            $index = 0; // Initialize counter variable

            foreach (array_unique($request->disId) as $discountId) {
                $discount = Discount::find($discountId);
                if ($discount && isset($cartProducts[$index])) {
                    $discountValue = $cartProducts[$index]->quantity * $discount->dis_rate;
                    $discountAmount += $discountValue;
                }

                $index++;
            }
            // dd($discountAmount);

            // Calculate subtotal, VAT, and payable amount
            $subTotal = 0;
            foreach ($request->qtyId as $key => $qtyId) {
                // Calculate the product subtotal
                $productByQtyPrice = ProductQty::find($qtyId)->unit_price * $request->qty[$key];
                $subTotal += $productByQtyPrice;

                // Update the current quantity
                $productQty = ProductQty::find($qtyId);
                $productQty->current_qty -= $request->qty[$key];
                $productQty->save();
            }

            $vat = ($subTotal * 3) / 100;


            // Calculate shipping cost
            $shippingSpace = 0;

            foreach ($cartProducts as $cartProduct) {
                $shippingSpace += ($cartProduct->product->width * $cartProduct->product->length * $cartProduct->quantity);
            }
            $shippingCost = $this->calculateShippingCost($request, $shippingSpace);
            $payable = $subTotal + $vat + $shippingCost - $discountAmount;
            // Create invoice
            $invoice = new Invoice();
            $invoice->total = $subTotal;
            $invoice->discount = $discountAmount;
            $invoice->vat = $vat;
            $invoice->shipping_cost = $shippingCost;
            $invoice->payable = $payable;
            $invoice->cus_details = $cus_details;
            $invoice->ship_details = $ship_details ?: $cus_details;
            $invoice->tran_id = $tran_id;
            $invoice->delivery_status = $delivery_status;
            $invoice->payment_status = $payment_status;
            $invoice->user_id = $user_id;
            $invoice->save();

            $invoiceID = $invoice->id;
            // dd($request->productId);

            foreach ($request->productId as $key => $EachProduct) {
                $product_qty = ProductQty::find($request->qtyId[$key]);
                // dd($product_qty);
                InvoiceProduct::create([
                    'invoice_id' => $invoiceID,
                    'qtyId' => $request->qtyId[$key],
                    'sku'=> $product_qty->sku,
                    'product_id' => $EachProduct,
                    'user_id' => $user_id,
                    'qty' =>  $request->qty[$key],
                    'product_sub_total' => $product_qty->unit_price * $request->qty[$key],
                ]);
            }

            $paymentMethod = SSLCommerz::InitiatePayment($profile, $payable, $tran_id, $user_email);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'paymentMethod' => $paymentMethod,
                'payable' => $payable,
                'vat' => $vat,
                'total' => $subTotal
            ], 200);

            // Handle successful invoice creation
        } catch (Exception $e) {
            DB::rollback();
            // Handle exceptions (e.g., log error, return response)
            return response()->json(['error' => $e], 500);
        }
    }


    function PaymentSuccess(Request $request)
    {
        // dd($request->all());
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to login to complete the payment.');
        }
        DB::beginTransaction();
        try {
            AddToCart::where('user_id', auth()->user()->id)->delete();
            SSLCommerz::InitiateSuccess($request->query('tran_id'));
            DB::commit();

            return redirect()->route('userDashboard')->with('success', 'Payment successful.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Redirect back with an error message
            return redirect()->back()->with('error', 'An error occurred while processing your payment. Please try again later.');
        }
    }


    function PaymentCancel(Request $request)
    {
        try {
            // Cancel the payment transaction using SSLCommerz
            SSLCommerz::InitiateCancel($request->query('tran_id'));

            // Retrieve the invoice based on the transaction ID
            $invoice = Invoice::where('tran_id', $request->query('tran_id'))->firstOrFail();

            $invoice_products = InvoiceProduct::where('invoice_id', $invoice->id)->get();

            foreach ($invoice_products as $invoice_product) {
                $product_qty = ProductQty::find($invoice_product->qtyId);
                $product_qty->update(['current_qty' => $product_qty->current_qty + $invoice_product->qty]);
            }

            return redirect()->route('userDashboard')->with('success', 'Payment cancelled successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions here
            return redirect()->route('userDashboard')->with('error', 'Payment cancellation failed.');
        }
    }


    function PaymentFail(Request $request)
    {
        DB::beginTransaction();

        try {
            SSLCommerz::InitiateFail($request->query('tran_id'));

            $invoice = Invoice::where('tran_id', $request->query('tran_id'))->firstOrFail();

            $invoice_products = InvoiceProduct::where('invoice_id', $invoice->id)->get();

            foreach ($invoice_products as $invoice_product) {
                $product_qty = ProductQty::find($invoice_product->qtyId);
                $product_qty->update(['current_qty' => $product_qty->current_qty + $invoice_product->qty]);
            }

            DB::commit();

            return redirect()->route('userDashboard')->with('success', 'Payment failed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('userDashboard')->with('error', 'Payment failure handling failed.');
        }
    }


    function PaymentIPN(Request $request)
    {
        dd($request->input('status'));
        return SSLCommerz::InitiateIPN($request->input('tran_id'), $request->input('status'), $request->input('val_id'));
    }


    private function calculateShippingCost($request, $shippingSpace)
    {
        if ($request->checkbox != null) {
            $shippingCostByDis = AvailableDistrict::find($request->district_id2);
        } else {
            $shippingCostByDis = AvailableDistrict::where('district_name', $request->district)->first();
        }

        $baseCost = $shippingCostByDis->base_cost;
        $costByCondition = $shippingCostByDis->cost_by_condition;

        if ($shippingSpace > 400) {
            $shippingSpace -= 400;
            return $baseCost + ($shippingSpace * $costByCondition);
        } else {
            return $baseCost;
        }
    }
}
