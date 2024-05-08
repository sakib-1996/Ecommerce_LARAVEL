<?php

namespace App\Console\Commands;

use App\Models\Discount;
use Illuminate\Console\Command;

class DiscountCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:discount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discount Time Check';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $discounts = Discount::where('status', 1)->get();

        $currentDateTime = now()->timestamp;

        foreach ($discounts as $discount) {
            $startDateTime = strtotime($discount->start_date);
            $endDateTime = strtotime($discount->end_date);

            if ($startDateTime <= $currentDateTime && $currentDateTime <= $endDateTime) {
                if ($discount->druft != 1) {
                    $discount->update(['druft' => 1]);
                    info("Discount activated");
                }
            }

            if ($endDateTime <= $currentDateTime) {
                // dd($discount->druft);
                if ($discount->druft != 0) {
                    $discount->update(['druft' => 0, 'status' => 0]);
                    info("Discount expired");
                }
            }
        }

        info("No action taken");
    }
}
