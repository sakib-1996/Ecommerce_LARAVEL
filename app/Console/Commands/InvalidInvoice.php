<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Console\Command;

class InvalidInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:invalid-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unsuccessInvoices = Invoice::whereIn('payment_status', ["Pending", "Fail"])->get();
        if ($unsuccessInvoices !== null) {
            foreach ($unsuccessInvoices as $unsuccessInvoice) {

                $createdAt = strtotime($unsuccessInvoice->created_at);

                $fiveMinutesAgo = strtotime('-2 minutes');

                if ($createdAt <= $fiveMinutesAgo) {
                    $invoiceProducts = InvoiceProduct::where('invoice_id', $unsuccessInvoice->id)->get();
                    foreach ($invoiceProducts as $invoiceProduct) {
                        $invoiceProduct->delete();
                        info("Invoice Product Deleted");
                    }
                    $unsuccessInvoice->delete();
                    info("Invoice Deleted");
                }
            }
        }
        info("Invoice not found");
    }
}
