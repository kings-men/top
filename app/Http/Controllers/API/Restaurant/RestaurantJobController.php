<?php

namespace App\Http\Controllers\API\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPostingRequest;
use App\Models\Equipment;
use App\Models\JobEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RestaurantJob;
use App\Models\JobFile;
use App\Models\Company;
use Exception;
use Auth;
use App\Models\User;
use DB;

class RestaurantJobController extends Controller
{

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

    public function jobPost(JobPostingRequest $request){

        $responseData = [];

            $data           =   $request->except(['restaurant_image','cusine','files_id']);
            $data['uuid']   =   Str::orderedUuid();
            $company_id = Company::where('user_id',Auth::user()->id)->first('id');
            $data['company_id'] = $company_id->id;

            // $latlong = getLatLong($address=null);

            $data['latitude']   =   111.12;
            $data['longitude']  =   111.12;

            $jobDetail      =   RestaurantJob::create($data);

            if($request->has('files_id')){
                $jobFile = new JobFile;
                foreach($request->files_id as $file_id){
                    $jobFile->updateOrCreate(['job_id'=>$jobDetail->id,'file_id'=>$file_id],['job_id'=>$jobDetail->id,'file_id'=>$file_id]);
                }
            }

            if($request->has('equipments_id')){
                $equipment = new JobEquipment;
                foreach($request->equipments_id as $equipment_id){
                    $equipment->updateOrCreate(['job_id'=>$jobDetail->id,'equipment_id'=>$equipment_id],['job_id'=>$jobDetail->id,'equipment_id'=>$equipment_id]);
                }
            }


            $this->mailNearByProviders();

            $jobDetail->with('files');
            $responseData['id'] = $jobDetail->uuid;
            $message            = __('messages.register_restaurant');
            $status_code        = 200;
            $status             = True;

        return common_response( $message, $status, $status_code, $responseData );
    }

    public function mailNearByProviders(){

        $emails = User::join('providers','providers.user_id','=','users.id')->get('email');

        if(count($emails) > 0){
            foreach($emails as $email){
                $details['email'] = $email;
                $details['message'] = "Message";
                dispatch(new \App\Jobs\EmailJob($details));

            }
        }

    }

    public function jobDetail(Request $request){

        if(!isset($request->uuid)){
            return common_response( 'Job id fields is require', False, 400, [] );
        }
        $responseData = [];

        $job_detail = RestaurantJob::where('uuid',$request->uuid)->with('files','files.fileDetail')->first();

        $message = !empty($job_detail) ? __('messages.success') : __('messages.no_record_found');

        $responseData       = $job_detail;
        $status_code        = 200;
        $status             = True;

        return common_response( $message, $status, $status_code, $responseData );
    }

    public function jobCancel(Request $request){

        if(!isset($request->job_id)){
            return common_response('Job id fields is require',False, 400,[]);
        }

        $responseData = [];

            $company_id = Company::where('user_id',\Auth::user()->id)->first('id');
            $job_creator_id = RestaurantJob::where('uuid',$request->job_id)->first('company_id');

            if( $company_id->id == $job_creator_id->company_id ){

                $job_detail = RestaurantJob::where('uuid',$request->job_id)->first('uuid');
                $message = !empty($job_detail) ? __('messages.cancel_job_success') : __('messages.no_record_found');
                RestaurantJob::where('uuid',$request->job_id)->update(['status'=>'Cancelled']);

            }else{

                $message = __('messages.not_authorized');
            }

            $responseData       = [];
            $status_code        = 200;
            $status             = True;

        return common_response( $message, $status, $status_code, $responseData );
    }

}
