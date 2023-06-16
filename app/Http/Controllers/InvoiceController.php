<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class InvoiceController extends Controller
{
    public function create_invoice(Request $request)
    {
        $item_additional =  "additional_info :{

        }";
        $add2 =  "additional_info :{

        }";
        $items[] = [
            "name" => $request['items'][0]['name'],
            "description" => $request['items'][0]['description'],
            "quantity" => $request['items'][0]['quantity'],
            "price" => $request['items'][0]['price'],
            "discount" => $request['items'][0]['discount'],
            "tax" => $request['items'][0]['tax'],
            $item_additional
        ];
        $postData = [ 
            "invoice_date"  => $request["invoice_date"],
            "due_date"  => $request["due_date"],
            "number" => $request["number"],
            "customer" => array(
                "id" => $request['customer']['id'],
                "name" => $request['customer']['name'],
                "email" => $request['customer']['email'],
                "phone" => $request['customer']['phone']
            ),
            "items" => $items,
            "total" => $request['total'],
            "signature_text_header" => $request['signature_text_header'],
            "signature_text_footer" => $request['signature_text_footer'],
            "terms_condition" => $request['terms_condition'],
            "notes" => $request['notes'],
            "send" => array(
                "email" => $request['send']['email'],
                "whatsapp" => $request['send']['whatsapp'],
                "sms" => $request['send']['sms'],
            ),
            $add2
        ];

        $data = json_encode($postData);
        
        // var_dump($data);
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://open-api.sandbox.paper.id/api/v1/store-invoice',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$data,
            CURLOPT_HTTPHEADER => array(
                'client_id: 5bc193b0e2ed43ba120892ae5db4fb1e',
                'client_secret: 2e35d75ab9d00cab613c22d1754f546d',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = array(
            'id' => $request["number"],
            'amount' => $request['total'],
            'status'    => 'Pending',
            'method'    =>'',
            'detail'     => 'Create Invoice'
        );
    }

    public function invoice_pay(Request $request)
    {
        $id = $request['invoice']['number'];
        $amount = $request['payment_info']['bank_transfer']['amount'];
        $method = $request['payment_info']['method'];
        $status = $request['payment_info']['bank_transfer']['status'];
        $data = array(
            'id' => $id,
            'amount' => $amount,
            'status'    => $status,
            'method'    => $method,
            'detail'     => 'Update Invoice'
        );
    }
}
