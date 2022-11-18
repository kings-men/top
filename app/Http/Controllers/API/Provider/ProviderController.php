<?php

namespace App\Http\Controllers\API\Provider;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProviderRequest;
use App\Http\Requests\ProviderProfileRequest;
use App\Models\ProviderService;
use Illuminate\Support\Str;
use App\Models\File;
use App\Models\ProviderDocument;
use Illuminate\Http\JsonResponse;
use Exception;
use Hash;

class ProviderController extends Controller
{

    public function register(ProviderRequest $request){

        $data = [
            'uuid'   =>   Str::orderedUuid(),
            'email'         =>$request->email,
            'first_name'    =>$request->first_name,
            'last_name'     =>$request->last_name,
            'password'      =>Hash::make($request->password),
            'contact_number'=>$request->phone,
            'city'          =>$request->city,
        ];
        $responseData   =   [];

        $user = User::create($data);
        $user_id = $user->id;

        //Assign role provider
        $role  =(new UserRole)->assignProviderRole($user_id);


        $message        =   __('messages.register_restaurant');
        $status_code    =   200;
        $status         =   True;

        $responseData   =   User::where('id',$user_id)->select(['uuid','first_name','last_name','contact_number','city','zipcode'])->first();
        $responseData['role']   =   $role;


        return common_response( $message, $status, $status_code, $responseData );

    }


    public function updateProfile(ProviderProfileRequest $request){

        $user           =   \Auth::user();
        $responseData   =   [];
        $data           =   $request->except(['prfile_image','service','email','phone']);

        if($request->has('service')){
            $services = $request->service;
        }

        $ifFound = Provider::where('user_id',$user->id)->first('id');
        if(empty($ifFound) && !isset($ifFound) ){
            $data['uuid']   =   Str::orderedUuid();
        }

        $responseData   =   Provider::updateOrCreate(['user_id'=>$user->id],$data);

        if(isset($services)){
            ProviderService::where('provider_id',$responseData->id)->whereNotIn('service_id',$services)->delete();
            $providerServices = new ProviderService;
            foreach($services as $service){
                $providerServices->updateOrCreate(['provider_id'=>$responseData->id,'service_id'=>$service],['provider_id'=>$responseData->id,'service_id'=>$service] );
            }
        }

        if($request->driver_license_front){
            $this->removingOldFiles($responseData->id, 'driver_license_front',$request->driver_license_front);
            $this->uploadingProviderDocument($request->driver_license_front,$responseData->id,'driver_license_front');
        }
        if($request->driver_license_back){
            $this->removingOldFiles($responseData->id, 'driver_license_back',$request->driver_license_back);
            $this->uploadingProviderDocument( $request->driver_license_back, $responseData->id, 'driver_license_back');
        }
        if($request->certification_license){
            $this->removingOldFiles($responseData->id, 'certification_license',$request->certification_license);
            $this->uploadingProviderDocument( $request->certification_license, $responseData->id, 'certification_license');
        }
        if($request->vehicle_license_plate){
            $this->removingOldFiles($responseData->id, 'vehicle_license_plate',$request->vehicle_license_plate);
            $this->uploadingProviderDocument( $request->vehicle_license_plate, $responseData->id, 'vehicle_license_plate');
        }
        if($request->provider_profile_picture){
            $this->removingOldFiles($responseData->id, 'provider_profile_picture',$request->provider_profile_picture);
            $this->uploadingProviderDocument( $request->provider_profile_picture, $responseData->id, 'provider_profile_picture');
        }

        $responseData = Provider::where('id',$responseData->id)->with('services')->with('states')->with('documents','documents.document')->first();

        $message        =   __('messages.register_restaurant');
        $status_code    =   200;
        $status         =   True;

        return common_response( $message, $status, $status_code, $responseData );

    }


    public function uploadingProviderDocument($file_id,$provider_id,$document_type){

        $data['path'] = 'providers/documents';
        ProviderDocument::updateOrCreate(['document_type'=>$document_type,'provider_id'=>$provider_id],['file_id'=>$file_id,'provider_id'=>$provider_id,'document_type'=>$document_type,'is_verified'=>1]);

        return True;
    }


    public function removingOldFiles($provider_id,$document_type,$file_id){

        $data = ProviderDocument::where(['provider_id'=>$provider_id,'document_type'=>$document_type])->with('document')->first();
        if(isset($data)){
            if($data->file_id != $file_id){
                if(isset($data['document']['name'])){

                    if(Storage::disk('public')->exists($data['document']['name'])){

                        Storage::disk('public')->delete($data['document']['name']);
                        File::where('id',$data->file_id)->delete();
                    }
                }
            }
        }

        return True;
    }

    public function profile(){

        $profile = User::where('id',\Auth::user()->id)
                    ->with('provider','provider.states')
                    ->with('provider.documents','provider.documents.document')
                    ->with('provider.services','provider.services.service')
                    ->first();

        return common_response( __('messages.success'), True, 200, $profile );

    }


}
