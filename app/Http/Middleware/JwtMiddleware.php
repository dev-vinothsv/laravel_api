<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
    {
		
        try {
			
            $user = JWTAuth::parseToken()->authenticate();
        
		} catch (TokenExpiredException $e) { 

			 return response()->json([
                'success' => false,
                'message' => 'Token is Expired'
            ], 400);
			 
		}catch (TokenInvalidException $e) {
			 
			
			 return response()->json([
                'success' => false,
                'message' => 'Token is Invalid'
            ], 400);
			 
		}catch (JWTException $e) {
			 
			 return response()->json([
                'success' => false,
                'message' => 'Token is Required'
            ], 400);
		}
       
	   $response = $next($request);
       $response->headers->set('Access-Control-Allow-Origin' , '*');
       $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
       $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');

    return $response;
    }
}
