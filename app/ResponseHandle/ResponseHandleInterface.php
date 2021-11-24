<?php
namespace App\ResponseHandle;


interface ResponseHandleInterface{
	
    public function successResponse($data, $message, $code);

    public function errorResponse($message , $code);
}
