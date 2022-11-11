<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\Storage;
use Exception;

class ServiceController extends Controller{


    public function create(ServiceRequest $request){
        $responseData = [];
        try{

            $service = Service::create($request->all());


            if($request->hasFile('logo')){
                $file = storeMediaFile($service,$request->logo, 'service_logo');
            }

            $responseData = $service;
            $responseData['logo'] = getSingleMedia($service,'service_logo',null);

            $message        =   __('messages.register_restaurant');
            $status_code    =   200;
            $status         =   True;

        } catch (Exception $e) {

            $message        = $e->getMessage();
            $status_code    = $e->getCode();
            $status         =   False;
            // DB::rollback();
            // exit;
        }

        return common_response( $message, $status, $status_code, $responseData );
    }

    public function getServices(Request $request){

        $service = Service::get(['id','name']);
        foreach($service as $servic){
            $servic['logo'] = getSingleMedia($servic,'service_logo',null);
        }
        return $service;
    }

}
