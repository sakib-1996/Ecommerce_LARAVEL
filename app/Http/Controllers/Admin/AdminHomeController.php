<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index()
    {
        $sales = null;
        $dalivared = null;
        $processing = null;
        $todaysOrder = null;

        $invoices = Invoice::get();
        if ($invoices->isNotEmpty()) {
            $sales = count($invoices);
            $dalivared = count(Invoice::where('delivery_status', "Completed")->get());
            $processing = count(Invoice::where('delivery_status', "Processing")->get());
            $todaysOrder = count(Invoice::whereDate('created_at', today())->get());
        } else {
            $sales = 0;
            $dalivared = 0;
            $processing = 0;
            $todaysOrder = 0;
        }

        // dd($todaysOrder);
        return view('admin.pages.dashboard.index', compact('sales', 'dalivared', 'processing', 'todaysOrder'));
    }

    
}
