<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\InvoiceProduct;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        // Get invoices with payment_status 'Success' and delivery status 'Pending' or 'Processing'
        $invoices = Invoice::where('payment_status', 'Success')
            ->whereIn('delivery_status', ['Pending', 'Processing'])
            ->orderByRaw("CASE WHEN delivery_status = 'Pending' THEN 0 ELSE 1 END")
            ->paginate(10);

        return view('admin.pages.orders.index', compact('invoices'));
    }




    public function ordersProduct($orderID)
    {
        $datas = InvoiceProduct::where('invoice_id', $orderID)->with('product', 'user', 'invoice')->get();
        // dd($datas);
        return response()->json($datas);
    }

    public function deliveryStatus(Request $request, $orderID)
    {
        // dd($request->deliveryStatus);
        $invoice = Invoice::find($orderID);
        $invoice->update(['delivery_status' => $request->deliveryStatus]);

        $notification = ['message' => 'Delivery Status is ' . $request->deliveryStatus . '!', 'alert-type' => 'success']; // Corrected typo in message
        return redirect()->back()->with($notification);
    }


    public function delivariedProduct()
    {
        // dd('hello');
        // Get invoices with delivery_status 'Completed' in descending order
        $invoices = Invoice::where('delivery_status', 'Completed')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pages.orders.delivaried', compact('invoices'));
    }
}
