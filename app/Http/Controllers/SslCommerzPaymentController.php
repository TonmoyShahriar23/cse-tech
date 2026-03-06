<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        $post_data = array();
        $post_data['total_amount'] = '10'; # You cannot pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        # Before going to initiate the payment order status need to insert or update as Pending.
        DB::table('orders')->updateOrInsert([
            'transaction_id' => $post_data['tran_id']
        ], [
            'name' => $post_data['cus_name'],
            'email' => $post_data['cus_email'],
            'phone' => $post_data['cus_phone'],
            'amount' => $post_data['total_amount'],
            'status' => 'Pending',
            'address' => $post_data['cus_add1'],
            'currency' => $post_data['currency']
        ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payment gateway here )
        return $sslc->makePayment($post_data, 'hosted');
    }










    public function success(Request $request)
    {
        Log::info('SSLCommerz success hit: method=' . $request->method() . ', tran_id=' . ($request->tran_id ?? 'N/A') . ', status=' . ($request->status ?? 'N/A'));
        
        // Handle POST request (Normal payment flow from SSLCommerz)
        if ($request->isMethod('post') && $request->status == 'VALID') {
            
            $update_product = DB::table('orders')
                ->where('transaction_id', $request->tran_id)
                ->update(['status' => 'Processing']);

            Log::info('Database Update Result for ' . $request->tran_id . ': ' . $update_product);

            // Store payment data in session
            session([
                'payment_status' => 'success',
                'payment_success' => true,
                'tran_id' => $request->tran_id,
                'amount' => $request->amount,
                'currency' => $request->currency ?? 'BDT',
                'card_type' => $request->card_type ?? 'SSLCommerz'
            ]);

            Log::info('Payment success data stored in session for tran_id: ' . $request->tran_id);
            
            // Return JavaScript redirect to avoid browser block issues
            return response()->view('payment.js_redirect', [
                'success_url' => route('payment.success')
            ]);
        }
        
        // Handle GET request (For redirection cases)
        if ($request->isMethod('get')) {
            if (session('payment_success')) {
                return response()->view('payment.js_redirect', [
                    'success_url' => route('payment.success')
                ]);
            }
            return redirect('/pricing')->with('error', 'Invalid Transaction');
        }

        return redirect('/pricing')->with('error', 'Payment Failed');
    }



























































    public function successPage()
    {
        if(session('payment_status') != 'success'){
            return redirect('/pricing');
        }

        return view('payment.success', [
            'tran_id' => session('tran_id'),
            'amount' => session('amount')
        ]);
    }

    public function generateInvoice()
    {
        if (!session()->has('tran_id')) {
            return redirect('/pricing')->with('error', 'Invoice session expired.');
        }

        $data = [
            'tran_id'   => session('tran_id'),
            'amount'    => session('amount'),
            'currency'  => session('currency', 'BDT'),
            'card_type' => session('card_type', 'SSLCommerz'),
        ];

        $pdf = Pdf::loadView('payment.invoice', $data);
        return $pdf->stream('Invoice_'.$data['tran_id'].'.pdf');
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_details = DB::table('orders')->where('transaction_id', $tran_id)->first();

        if ($order_details && $order_details->status == 'Pending') {
            DB::table('orders')->where('transaction_id', $tran_id)->update(['status' => 'Failed']);
            return redirect('/pricing')->with('error', 'Transaction Failed');
        }
        return redirect('/pricing');
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $order_details = DB::table('orders')->where('transaction_id', $tran_id)->first();

        if ($order_details && $order_details->status == 'Pending') {
            DB::table('orders')->where('transaction_id', $tran_id)->update(['status' => 'Canceled']);
            return redirect('/pricing')->with('error', 'Transaction Canceled');
        }
        return redirect('/pricing');
    }

    public function ipn(Request $request)
    {
        if ($request->input('tran_id')) {
            $tran_id = $request->input('tran_id');
            $order_details = DB::table('orders')->where('transaction_id', $tran_id)->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                
                if ($validation == TRUE) {
                    DB::table('orders')->where('transaction_id', $tran_id)->update(['status' => 'Processing']);
                    echo "Transaction is successfully Completed";
                }
            }
        }
    }
}