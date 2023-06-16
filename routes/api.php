<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\InvoiceController as Invoice;

Route::post('/create_invoice', [Invoice::class, 'create_invoice']);
Route::post('/invoice_pay', [Invoice::class, 'invoice_pay']);

use App\Http\Controllers\PaymentController as Payment;

Route::post('/success_pay', [Payment::class, 'success_pay']);
Route::post('/failed_pay', [Payment::class, 'failed_pay']);