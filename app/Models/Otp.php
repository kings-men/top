<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Otp extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'otps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier', 'token', 'otp', 'validity'
    ];


    public function verifyOtp($email,$otp){

        $response =[];
        $row = self::where(['identifier'=>$email,'otp'=>$otp])->first();

        if($row){
            //Creatig a random string token
            $token = Str::random(50);
            Otp::UpdateOrCreate(['identifier'=>$email],['identifier'=>$email,'token'=>$token,'validity'=>15,'valid'=>1]);

            $response['data'] = [
                'token' => $token,
                'email' => $email
            ];

            $response['status'] = True;
            $response['message'] = trans('messages.success_verify_otp');
            $response['status_code'] = 200;

        }else{

            $response['status'] = False;
            $response['message'] = trans('messages.failed_verify_otp');
            $response['data']=[];
            $response['status_code'] = 400;
        }

        return $response;
    }
}
