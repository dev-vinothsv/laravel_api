<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model{
	
	use HasFactory;
	
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name','car_image','year','model','color','fuel_type','mileage','seating_capacity', 'boot_space'
    ];
	
	public function updateCar($request_data,$id){
		$car = Car::find($id);
		$car->year = $request_data["year"];
		$car->model = $request_data["model"]; 
		$car->color = $request_data["color"];
		$car->fuel_type = $request_data["fuel_type"];
		$car->mileage = $request_data["mileage"];
		$car->seating_capacity = $request_data["seating_capacity"];
		$car->boot_space = $request_data["boot_space"];
		if($car->save()){
		return $car;
		}else{			
		return 0;
		}
		
	}
	
	
	

	
	
}
