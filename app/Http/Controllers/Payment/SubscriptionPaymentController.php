<?php

namespace App\Http\Controllers\Payment;

use App\TheApp\Repository\Api\Packages\PackageRepository;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class SubscriptionPaymentController extends ApiController
{
    function __construct(PackageRepository $package)
    {
        $this->packageModel       = $package;
    }

    const EMAIL_MYFATOORAH    = "testapi@myfatoorah.com";
    const PASSWORD_MYFATOORAH = "E55D0";
    const CODE_MYFATOORAH     = "999999";

    public function send($request)
    {
        $package = $this->packageModel->packageById($request['package_id']);

        $url = "https://test.myfatoorah.com/pg/PayGatewayServiceV2.asmx?op=PayRequestV1";

        $xml_data = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
            xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
            xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
              <PaymentRequest xmlns="http://tempuri.org/">
                <req>
                  <CustomerDC>
                    <Name>      '. Auth::user()->name . '</Name>
                    <Email>     '. Auth::user()->email . '</Email>
                    <Mobile>    '. Auth::user()->mobile  . '</Mobile>
                    <Gender></Gender>
                    <DOB></DOB>
                    <civil_id></civil_id>
                    <Area></Area>
                    <Block></Block>
                    <Street></Street>
                    <Avenue></Avenue>
                    <Building></Building>
                    <Floor></Floor>
                    <Apartment></Apartment>
                  </CustomerDC>
                  <MerchantDC>
                    <merchant_code>'     . self::CODE_MYFATOORAH    . '</merchant_code>
                    <merchant_username>' . self::EMAIL_MYFATOORAH   . '</merchant_username>
                    <merchant_password>' . self::PASSWORD_MYFATOORAH. '</merchant_password>
                    <merchant_ReferenceID>' . uniqid()              . '</merchant_ReferenceID>
                    <ReturnURL>'        . url(route('SubscribeSuccess')) . '</ReturnURL>
                    <merchant_error_url>'. url(route('SubscribeFailed'))  . '</merchant_error_url>
                    <udf1>'.    $package['id']        . '</udf1>
                    <udf2>'.    $package['price']     .'</udf2>
                    <udf3>'.    null                .'</udf3>
                    <udf4>'.    null                .'</udf4>
                    <udf5>'.    Auth::user()->id   .'</udf5>
                  </MerchantDC>
                  <lstProductDC>
                    <ProductDC>
                      <product_name></product_name>
                      <unitPrice>'.$package['price'].'</unitPrice>
                      <qty>1</qty>
                    </ProductDC>
                  </lstProductDC>
                  <totalDC>
                    <subtotal>'.$package['price'].'</subtotal>
                  </totalDC>
                  <paymentModeDC>
                    <paymentMode>both</paymentMode>
                  </paymentModeDC>
                  <paymentCurrencyDC>
                    <paymentCurrrency>KWD</paymentCurrrency>
                  </paymentCurrencyDC>
                </req>
              </PaymentRequest>
            </soap:Body>
        </soap:Envelope>';

        // send request
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        // convert xml to json
        $xml    = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
        $xml    = \simplexml_load_string($xml);
        $json   = json_encode($xml);
        $responseArray = json_decode($json, true);

        return $responseArray['soapBody']['PaymentRequestResponse']['PaymentRequestResult'];
    }

    public function success(Request $request)
    {
        $data = $this->getOrderStatus($request['id']);
        

        if ($data['ResponseMessage'] == 'SUCCESS') {
    
            $finalStep = $this->packageModel->finalStep($data);

            return 1;
        }

    }

    public function error(Request $request)
    {
        $data = $this->getOrderStatus($request['id']);

        return response()->json([
            'message' => 'فشلت محاولة الدفع تآكد من البيانات',
            'code'    => 401 
        ],401);    
    }

    public function getOrderStatus($referenceID)
    {
        $URL = "https://test.myfatoorah.com/pg/PayGatewayServiceV2.asmx?op=GetOrderStatusRequest";

        $xml_data = 
        '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
                xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                  <GetOrderStatusRequest xmlns="http://tempuri.org/">
                    <getOrderStatusRequestDC>
                      <merchant_code>'. self::CODE_MYFATOORAH.'</merchant_code>
                      <merchant_username>'.self::EMAIL_MYFATOORAH.'</merchant_username>
                      <merchant_password>'.self::PASSWORD_MYFATOORAH.'</merchant_password>
                      <referenceID>'.$referenceID.'</referenceID>
                    </getOrderStatusRequestDC>
                  </GetOrderStatusRequest>
                </soap:Body>
            </soap:Envelope>';
        

        // send request
        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        // convert xml to json
        $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $output);
        $xml = \simplexml_load_string($xml);
        $json = json_encode($xml);
        $responseArray = json_decode($json, true);

        return $responseArray['soapBody']['GetOrderStatusRequestResponse']['GetOrderStatusRequestResult'];
    }

}