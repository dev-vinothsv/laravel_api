<?php
namespace App;

use Illuminate\Http\Request;
use Log;
use Response;
use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class Helpers { 
	
	 /*Log the Request && Response*/
	
	 public static function apiLog($api_desc,$token='',$params=''){    	
    	$api_log = new Logger('api');
    	$api_log->pushHandler(new StreamHandler(storage_path(env('API_LOG_PATH'))), Logger::INFO);    
    	$token_desc = "TOKEN: ".$token;
    	$desc = $token_desc.' '.$api_desc;
    	$api_log->info($desc,(array)$params);    
    } 
	
	
	public static function uploadImage($input_image,$input_file_name,$input_file){
	
	if($input_image) {
			#check local or production
			if (env('APP_ENV') == 'local') {
				$directory = public_path() . env('CAR_IMAGE_PATH');
			} else {
				$directory = env('CAR_IMAGE_PATH');
			}
		 	$fileName = strtotime(date('Y-m-d H:i:s')) . '-' . str_replace(' ', '-', $input_file_name);		
				$car_image_path = env('CAR_IMAGE_PATH') . '/' . $fileName;
         # save the file locally ALWAYS
			Log::info("save the car image to the local file system: $directory/$fileName ");
			 $input_file->move($directory, $fileName);
			
			return  $fileName;
		}

	}
}
?>

