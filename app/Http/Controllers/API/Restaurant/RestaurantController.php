<?php

namespace App\Http\Controllers\API\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\CompanyLocation;
use App\Http\Requests\RestaurantRequest;
use App\Http\Requests\RestaurantProfileRequest;
use App\Models\User;
use App\Models\UserRole;
use App\Models\RestaurantCuisine;
use Hash;
use DB;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{

    public function register(RestaurantRequest $request){

        $responseData   =   [];
        $data = [
            'uuid'   =>   Str::orderedUuid(),
            'email'         =>$request->email,
            'display_name'  =>$request->full_name,
            'password'      =>Hash::make($request->password),
            'contact_number'=>$request->contact_number
        ];

        $user = User::create($data);
        $user_id = $user->id;

        //Assign role provider
        $role  =(new UserRole)->assignRestaurantRole($user_id);

        if($user_id){

            // Registering a Company
            $companyDetail = [
                'uuid'      =>  Str::orderedUuid(),
                'user_id'   =>  $user_id,
                'status'    =>  'pending',
                'subscription_status'   =>  'pending',
                'business_name'=>$request->business_name,
            ];
            $company = Company::create($companyDetail);
            $company_id = $company->id;

            // Registering a Company Restaurant
            if($company_id){
                $companyLocationDetalil = [
                    'uuid'          =>  Str::orderedUuid(),
                    'company_id'    =>  $company_id,
                    'phone_number'  =>  $request->contact_number,
                    'contact_name'  =>  $request->full_name,
                    'email'         =>  $request->email,
                    'city'          =>  $request->city,
                ];
                CompanyLocation::create($companyLocationDetalil);
            }
        }

        $responseData = Company::where('id',$company->id)->with('location')->first();
        $responseData['role'] = $role;
        $message        =   __('messages.register_restaurant');
        $status_code    =   200;
        $status         =   True;

        return common_response( $message, $status, $status_code, $responseData );

    }


    public function updateProfile(RestaurantProfileRequest $request){

        $user = \Auth::user();
        $user_id = $user->id;
        $responseData = [];

        if( isset($request->cusine) && count($request->cusine) > 0 ){
            $cuisines = $request->cusine;
        }

        $data = $request->except(['logo_file_id','cusine']);
        $restaurant = Company::where('user_id',$user_id)->first('id');
        $restaurant->updateOrCreate(['id'=>$restaurant->id],['logo_file_id'=>$request->logo_file_id]);

        CompanyLocation::updateOrCreate(['company_id'=>$restaurant->id],$data);

        if(isset($cuisines)){
            RestaurantCuisine::whereNotIn('cuisine_id',$cuisines)->delete();
            $restaurantCuisine = (new RestaurantCuisine);
            foreach($cuisines as $cuisine){
                $restaurantCuisine->updateOrCreate(['cuisine_id'=>$cuisine,'restaurant_id'=>$restaurant->id],['cuisine_id'=>$cuisine,'restaurant_id'=>$restaurant->id] );
            }
        }

        $responseData   =   Company::where('user_id',$user->id)->with('location')->with('cuisines','file')->first();
        $responseData['restaurant_profile'] = getSingleMedia($user,'restaurant_profile',null);

        $message        =   __('messages.register_restaurant');
        $status_code    =   200;
        $status         =   True;


        return common_response( $message, $status, $status_code, $responseData );

    }

    public function profile(Request $request){

        $responseData = User::where('id',\Auth::user()->id)->with('company','company.file','company.location')
        ->with('company.cuisines','company.cuisines.cuisine')
        ->first();

        return common_response( __('messages.success'), True, 200, $responseData );
    }


}
