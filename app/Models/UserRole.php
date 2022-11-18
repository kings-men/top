<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'role_id',
    ];

    public function assignRestaurantRole($user_id){
        $response   =   self::updateOrCreate(['user_id'=>$user_id],['user_id'=>$user_id, 'role_id'=>6]);
        $roleName   =   Role::where('id',$response->role_id)->first('name');
        return $roleName;
    }
    public function assignProviderRole($user_id){
        $response   =   self::updateOrCreate(['user_id'=>$user_id],['user_id'=>$user_id, 'role_id'=>4]);
        $roleName   =   Role::where('id',$response->role_id)->first(array('name'));
        return $roleName;
    }
    public function roleDetail(){
        return $this->hasOne(Role::class, 'id','role_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id','user_id');
    }

}
