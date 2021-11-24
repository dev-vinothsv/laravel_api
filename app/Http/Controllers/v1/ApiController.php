<?php

namespace App\Http\Controllers\v1;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Helpers;
use App\ResponseHandle\ResponseHandle;
use Lang;
class ApiController extends Controller { 
	
	protected $api_response;
	public  function __construct(ResponseHandle $handle_response){
			$this->api_response = $handle_response;
		
    }
	
	 /**
     *  User register .
     *  @param  \Illuminate\Http\Request  $request 
     *  @return \Illuminate\Http\Response
     */
	 
	
	  protected function register(Request $request){
		  
    	//Validate data
        $data = $request->only('first_name','last_name','phone','address','city','state','zip','email', 'password');
		
		Helpers::apiLog('Request params','',$data);
		
        $validator = Validator::make($data, [            
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
			//$response_data = response()->json(['error' => $validator->messages()], 200);
		    $response_data = $this->api_response->errorResponse($validator->messages(),Response::HTTP_OK);
			Helpers::apiLog('Response params','',$response_data);
			return $response_data;          
        }
		
		$request_data = array();
		$request_data['first_name'] = $request->first_name;
		$request_data['last_name'] = $request->last_name;
		$request_data['username'] = $request->email;
		$request_data['phone'] = $request->phone;
		$request_data['address'] = $request->address;
		$request_data['city'] = $request->city;
		$request_data['state'] = $request->state;
		$request_data['zip'] = $request->zip;
		$request_data['email'] = $request->email;
		$request_data['confirm'] = 1;
		$request_data['password'] =  bcrypt($request->password);
        //Request is valid, create new user
		
		$user = new User();				
		$user_details = $user->CreateUser($request_data); 
		$response_data = $this->api_response->successResponse($user_details,Lang::get('API.USER_CREATED'),Response::HTTP_OK);
		
		Helpers::apiLog('Response params','',$response_data);
		
        //User created, return success response
        return $response_data;
    }
	
	 /**
     *  User Login .
     *  @param  \Illuminate\Http\Request  $request 
     *  @return \Illuminate\Http\Response
     */
	
	
	protected function authenticate(Request $request){
		
        $credentials = $request->only('email', 'password');
		$email = false;	
		if(isset($email))	{
			
			
		}
		$email = false;
		if(empty($email)){
			
			
		}
        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
			return  $response_data = $this->api_response->errorResponse($validator->messages(),Response::HTTP_OK);
        }

        //Request is validated and create token        
        try {
            if (!$token = JWTAuth::attempt($credentials)) {               
				return $response_data = $this->api_response->errorResponse(Lang::get('API.USER_LOGIN_INVALID'),Response::HTTP_UNAUTHORIZED );
            }
        } catch (JWTException $e) {
			return $response_data = $this->api_response->errorResponse(Lang::get('API.USER_TOKEN_NOT_CREATED'),Response::HTTP_OK);
            
        }
 	
 		//Token created, return with success response and jwt token
		return $response_data = $this->api_response->successResponse(['token' => $token],Lang::get('API.USER_TOKEN_CREATED'),Response::HTTP_OK);
        
    }
	
}
