<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function success_pay(Request $request)
    {
        $id = $request['ref_id'];
        $amount = $request['payment_info']['bank_transfer']['amount'];
        $method = $request['payment_info']['method'];
        $status = $request['payment_info']['bank_transfer']['status'];
        $data = array(
            'id' => $id,
            'amount' => $amount,
            'status'    => $status,
            'method'    => $method,
            'detail'     => 'Payment Success'
        );
    }

    public function failed_pay(Request $request)
    {
        $id = $request['ref_id'];
        $amount = $request['payment_info']['bank_transfer']['amount'];
        $method = $request['payment_info']['method'];
        $status = $request['payment_info']['bank_transfer']['status'];

        $data = array(
            'id' => $id,
            'amount' => $amount,
            'status'    => $status,
            'method'    => $method,
            'detail'     => 'Payment Failed'
        );
    }
}
