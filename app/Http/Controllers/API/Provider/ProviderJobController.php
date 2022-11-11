<?php

namespace App\Http\Controllers\API\Provider;

use App\Http\Controllers\Controller;
use App\Models\RestaurantJob;
use Illuminate\Http\Request;
use Exception;

class ProviderJobController extends Controller{

    public function jobs(Request $request){

        $filter = [];
        if($request->has('service_id') && count($request->service_id)>0 ){
            $filter['service_id'] = $request->service_id;
        }

        $responseData = RestaurantJob::whereNotIn('status',['Cancelled','InProgress'])
                        ->with('service')->with('company','files','files.fileDetail')
                        ->whereIn('service_id',$filter['service_id'])->get();

        $message        =   __('messages.success');
        $status_code    =   200;
        $status         =   True;

        return common_response( $message, $status, $status_code, $responseData );
    }
}
