<?php

namespace App\Helper;

use App\Models\Invoice;
use App\Models\SslcommerzAccount;
use Exception;
use Illuminate\Support\Facades\Http;

class SSLCommerz
{

    static function  InitiatePayment($profile, $payable, $tran_id, $user_email): array
    {
        try {
            $ssl = SslcommerzAccount::first();
            $response = Http::asForm()->post($ssl->init_url, [
                "store_id" => $ssl->store_id,
                "store_passwd" => $ssl->store_passwd,
                "total_amount" => $payable,
                "currency" => $ssl->currency,
                "tran_id" => $tran_id,
                "success_url" => "$ssl->success_url?tran_id=$tran_id",
                "fail_url" => "$ssl->fail_url?tran_id=$tran_id",
                "cancel_url" => "$ssl->cancel_url?tran_id=$tran_id",
                "ipn_url" => $ssl->ipn_url,
                "cus_name" => $profile->first_name . ' ' . $profile->last_name,
                "cus_email" => $user_email,
                "cus_add1" => $profile->address_1,
                "cus_add2" => $profile->address_2,
                "cus_city" => $profile->city,
                "cus_state" => $profile->city,
                "cus_postcode" => $profile->post_code,
                "cus_country" => $profile->country->country_name,
                "cus_phone" => auth()->user()->phone,
                "product_amount" => $payable,
                "shipping_method"=>'NO',
                'product_name'=>'kjdfhn',
                'product_category'=>"djfbng",
                'product_profile'=>"jfdhg",
            ]);
            return $response->json();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    static function InitiateSuccess($tran_id)
    {
        // dd("hello");
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Success']);
        return 1;
    }








    static function InitiateFail($tran_id)
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Fail']);
        return 1;
    }



    static function InitiateCancel($tran_id)
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => 'Cancel']);
        return 1;
    }

    static function InitiateIPN($tran_id, $status, $val_id)
    {
        Invoice::where(['tran_id' => $tran_id, 'val_id' => 0])->update(['payment_status' => $status, 'val_id' => $val_id]);
        return 1;
    }
}
