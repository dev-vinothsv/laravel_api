<?php

namespace App\Http\Controllers\v1;

use App\Models\Car;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Helpers;
use JWTAuth;
use App\ResponseHandle\ResponseHandle;
use App\Repository\CarRepository;
use Lang;
class CarController extends Controller{
	
	
	protected $user;
	protected $api_response;
	public  function __construct(ResponseHandle $handle_response,CarRepository $car){
			$this->api_response = $handle_response;
			$this->car = $car;
		
    }
  
	  /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    protected function ShowCars(){
		
		$car = Car::hasOne(Phone);
	   $cars = $this->car->all();
	   
	  	Helpers::apiLog('Cars','',$cars);    
      
		return $response_data = $this->api_response->successResponse($cars,Lang::get('API.CAR_LISTED'),Response::HTTP_OK);
    }
	
	 /**
     * Display the specified resource.
     *
     * @param  $car_id
     * @return \Illuminate\Http\Response
     */
	protected function getCar($car_id){
		
	   
	   $car = $this->car->show($car_id);
	   
	  	Helpers::apiLog('Car','',$car);    
      
		return $response_data = $this->api_response->successResponse($car,Lang::get('API.CAR_LISTED'),Response::HTTP_OK);
    }
	
	
	
	 /**
     * Store the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */	
	
	protected function createCar(Request $request){
	//Validate data
        $data = $request->only('name','car_image','year','model','color','fuel_type','mileage','seating_capacity', 'boot_space');
		
		Helpers::apiLog('Request params','',$data);
		
        $validator = Validator::make($data, [            
            'name' => 'required',
			'car_image' => 'image:jpeg,png,jpg,gif,svg|max:2048',
            'year' => 'required|min:4|max:4',
			'model' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
			$response_data = $this->api_response->errorResponse($validator->messages(),Response::HTTP_OK);
			Helpers::apiLog('Response params','',$response_data);
			return $response_data;          
        }
		
		$car_image = $request->car_image;
		if(isset($car_image)){
		$car_file = $request->file('car_image');
		$car_file_name = $request->file('car_image')->getClientOriginalName();
		$car_image_details = Helpers::uploadImage($car_image,$car_file_name,$car_file);
		}
		
		$request_data = array();
		$request_data['name'] = $request->name;
		if(isset($car_image_details)){
		$request_data['car_image'] = $car_image_details;
		}
		$request_data['year'] = $request->year;
		$request_data['model'] = $request->model;	
		$request_data['color'] = $request->color;
		$request_data['fuel_type'] = $request->fuel_type;
		$request_data['mileage'] = $request->mileage;
		$request_data['seating_capacity'] = $request->seating_capacity;
		$request_data['boot_space'] = $request->boot_space;
	
        //Request is valid, create new car	
		
		try{
			$user = JWTAuth::parseToken()->authenticate();
			 $car = $user->cars()->create($request_data);
		}catch(QueryException $e){		
			$response_data = $this->api_response->errorResponse('Car not created',Response::HTTP_OK);			
		}
		
		if(isset($car->id)){			
			$response_data = $this->api_response->successResponse($car,Lang::get('API.CAR_CREATED'),Response::HTTP_CREATED);			
		}

		Helpers::apiLog('Response params','',$response_data);
		
        //Car created, return success response
        return $response_data;
	
	}
	
	
	
	 /**
     * Update the specified resource.
     *
     * @param   $car_id
     * @return \Illuminate\Http\Response
     */	
	
	protected function updateCar(Request $request,$car_id){
	//Validate data
        $data = $request->only('name','car_image','year','model','color','fuel_type','mileage','seating_capacity', 'boot_space');
		
		Helpers::apiLog('Request params','',$data);
		
        $validator = Validator::make($data, [            
            'name' => 'required',			
            'year' => 'required|min:4|max:4',
			'model' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {			
			$response_data = $this->api_response->errorResponse($validator->messages(),Response::HTTP_OK);
			Helpers::apiLog('Response params','',$response_data);
			return $response_data;          
        }
	
		$request_data = array();
		$request_data['id'] = $car_id;	
		$request_data['name'] = $request->name;		
		$request_data['year'] = $request->year;
		$request_data['model'] = $request->model;	
		$request_data['color'] = $request->color;
		$request_data['fuel_type'] = $request->fuel_type;
		$request_data['mileage'] = $request->mileage;
		$request_data['seating_capacity'] = $request->seating_capacity;
		$request_data['boot_space'] = $request->boot_space;
	
        //Request is valid, update new car	
		
		try{
			$car = new Car();
			$user = JWTAuth::parseToken()->authenticate();
			$is_car_exist = Car::where('id', $car_id)->exists();
			if($is_car_exist){							
				$car_details = $this->car->update($car_id,$request_data);				
			}else{				
				return 	$response_data = $this->api_response->errorResponse(Lang::get('API.CAR_NOT_FOUND'),Response::HTTP_OK);
				
			}
		}catch(Exception $e){
			
			return 	$response_data = $this->api_response->errorResponse(Lang::get('API.CAR_NOT_FOUND'),Response::HTTP_OK);
		}
		
		$response_data = $this->api_response->successResponse($car_details,Lang::get('API.CAR_UPDATED'),Response::HTTP_OK );		

		Helpers::apiLog('Response params','',$response_data);
		
        //Car created, return success response
        return $response_data;
	
	}
	
	
	 /**
     * Delete the specified resource.
     *
     * @param   $car_id
     * @return \Illuminate\Http\Response
     */	
	
	
	protected function deleteCar(Request $request){
		
		$id = $request->car_id;    
        $car= Car::find($id);
		$is_car_exist = Car::where('id', $id)->exists();
        if($is_car_exist && $car->delete()){		
			$response_data = $this->api_response->successResponse($car,Lang::get('API.CAR_DELETED'),Response::HTTP_OK );						
		}else{
			$response_data = $this->api_response->successResponse($car,Lang::get('API.CAR_NOT_DELETED'),Response::HTTP_OK );			
		}			
		return $response_data;				
	}
	
	
}
