<?php

namespace App\ResponseHandle;

class ResponseHandle
{
    public function successResponse($data= array(), $message='', $code=200)
	{
		return response()->json([
			'status'=> 'Success', 
			'message' => $message, 
			'data' => $data
		], $code);
	}

	public function errorResponse($message, $code)
	{
		return response()->json([
			'status'=>'Error',
			'message' => $message,
			'data' => null
		], $code);
	}
}


