<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }
	
	public function Cars(){
        return $this->hasMany(Car::class);
    }
	
	public function CreateUser($request_data){
	
		$user = new User();
		$user->first_name = $request_data['first_name'];
		$user->last_name = $request_data['last_name'];
		$user->username = $request_data['username'];
		$user->phone = $request_data['phone'];
		$user->address = $request_data['address'];
		$user->city = $request_data['city'];
		$user->state = $request_data['state'];
		$user->zip = $request_data['zip'];
        $user->email = $request_data['email'];
		$user->confirm = 1;
        $user->password = $request_data['password'];
        $user->save();		
		
		return $user;	
	}
	

	
  
}