<?php
namespace App\TheApp\Repository\Api\V2\Transaction;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Auth;
use DB;

class TransactionRepository
{
    protected $model;

    function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }

    public function addNew($data)
    {

        $userPayment = $this->model->create([
		        'ResponseMessage'=>isset($data['ResponseMessage'])? $data['ResponseMessage']:null,
		        'ResponseCode'	 =>isset($data['ResponseCode'])	  ? $data['ResponseCode'] : null,
		        'gross_amount'	 =>isset($data['gross_amount'])	  ? $data['gross_amount'] : null,
		        'net_amount'  	 =>isset($data['net_amount'])	  ? $data['net_amount'] 	: null,
		        'PostDate'	  	 =>isset($data['PostDate'])		  ? $data['PostDate'] 	: null,
		        'PayTxnID'	  	 =>isset($data['PayTxnID'])		  ? $data['PayTxnID'] 	: null,
		        'Paymode'	  	 =>isset($data['Paymode'])		  ? $data['Paymode'] 		: null,
		        'TransID'	  	 =>isset($data['TransID'])		  ? $data['TransID'] 		: null,
		        'result'	  	 =>isset($data['result'])		  ? $data['result'] 		: null,
		        'AuthID'	  	 =>isset($data['AuthID'])		  ? $data['AuthID'] 		: null,
		        'RefID'		  	 =>isset($data['RefID'])		  ? $data['RefID'] 		: null,
		        'User_Id'	  	 =>isset($data['udf5'])			  ? $data['udf5'] 		: null,
		        'Price'	 		 =>isset($data['udf2'])			  ? $data['udf2'] 		: null,
		        'Order_id'    	 =>isset($data['udf1'])			  ? $data['udf1'] 		: null,
		    ]);

        return true;

    }
}
