<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class OrderPaymentController extends ApiController
{
		// LIVE CREDENTIALS
		// const MERCHANT_ID    = "4746";
    // const USERNAME 			 = "daftarkw";
		// const PASSWORD     	 = "mEyCWGJ/57#z/{85";
    // const API_KEY        = "Ac16aaCGbM7isqbjJRflf63w3ODzsWOJ3vmyZhri";

		// TEST CREDENTIALS
		const MERCHANT_ID    = "1201";
    const USERNAME 			= "test";
		const PASSWORD     	= "test";
    const API_KEY        = "jtest123";

		public function send($order,$type,$payment)
		{
				$url = $this->paymentUrls($type);

				$fields = [
					'api_key'					=> self::API_KEY,
					// 'api_key'					=> password_hash(self::API_KEY,PASSWORD_BCRYPT),
					'merchant_id'			=> self::MERCHANT_ID,
					'username' 				=> self::USERNAME,
					'password' 				=> self::PASSWORD,
					// 'password' 				=> stripslashes(self::PASSWORD),
					'order_id' 				=> $order['id'],
					'CurrencyCode'		=> 'KWD', //only works in production mode
					'CstFName' 				=> auth()->user() ? auth()->user()->name : 'null',
					'CstEmail'				=> auth()->user() ? auth()->user()->email : 'null',
					'CstMobile'				=> auth()->user() ? auth()->user()->mobile : 'null',
					'success_url'   	=> $url['success'],
					'error_url'				=> $url['failed'],
					'test_mode'    		=> 1, // test mode enabled
					// 'test_mode'    		=> 0,
					'whitelabled'    	=> false,
					'payment_gateway'	=> $payment,// knet / cc
					'reference'				=> $order['id'],
					'notifyURL'				=> url(route('api.orders.webhooks')),
					'total_price'			=> $order['total'],
				];

				$fields_string = http_build_query($fields);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/test-payment"); curl_setopt($ch, CURLOPT_POST, 1);
				// curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/payment-request"); curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); $server_output = curl_exec($ch);
				curl_close($ch);
				$server_output = json_decode($server_output,true);

				return $server_output['paymentURL'];
		}

    public function paymentUrls($type)
    {
        if ($type == 'orders') {
  					$url['success'] = url(route('api.orders.success'));
          	$url['failed']  = url(route('api.orders.failed'));
        }

				return $url;
    }
}
