<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

trait ExceptionTrait
{
	public function apiException($request,$e)
	{
		if ($e instanceof ModelNotFoundException) {
			return $this->ModelResponse($e);
		}

		if ($e instanceof NotFoundHttpException) {
		    return $this->HttpResponse($e);
		}

    	if($e instanceof ValidationException){
		    return $this->PrintArrayOfErrors($e);
		}

		return parent::render($request, $e);
	
	}

	protected function ModelResponse($e)
	{
		return response()->json([
					'data'   		=> [],
					'successfully'	=> false,
                    'errors' 		=> [ 'This ID Not Found' ],
                ],404);
	}
	
	protected function HttpResponse($e)
	{
		return response()->json([
					'data'   		=> [],
					'successfully'	=> false,
                    'errors' 		=> [ 'This Route Not Found' ],
                ],404);
	}

	protected function PrintArrayOfErrors($e)
	{
		return response()->json([
					'data'   		=> [],
					'successfully'	=> false,
                    'errors' => $e->validator->errors()->all()
                ],400 );
	}

}