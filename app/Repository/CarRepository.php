<?php

namespace App\Repository;
use App\Models\Car;
class CarRepository implements CarRepositoryInterface
{
      // model property on class instances
   
 

    // Get all instances of model
    public function all()
    {
      return Car::all();
    }

    // create a new record in the database
    public function create(array $data)
    {
       
    }

    // update record in the database
    public function update( $id,array $data)
    {
		$car = Car::find($id);
		if($car->id >0){
			$car = new Car();
		}
		
		$car
	
	 
	 
         if(Car::find($id)->update($data)){
			 return Car::find($id);
		 };
    }

    // remove record from the database
    public function delete($id)
    {
         return Car::destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return Car::find($id);
    }

    

  
}


