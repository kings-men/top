<?php

namespace App\Http\Controllers\API\Provider;

use Auth;
use Mail;
use Exception;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Models\RestaurantJob;
use App\Models\JobApplication;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyJobRequest;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Trunc;

class ProviderJobController extends Controller{

    public function jobs(Request $request){

        $filter = [];
        if($request->has('service_id') && count($request->service_id)>0 ){
            $filter['service_id'] = $request->service_id;
        }

        $responseData = RestaurantJob::whereNotIn('status',['Cancelled','InProgress'])
                        ->with('service')->with('company','files','files.fileDetail')
                        ->whereIn('service_id',$filter['service_id'])
                        ->get();

        $message        =   __('messages.success');
        $status_code    =   200;
        $status         =   True;

        return common_response( $message, $status, $status_code, $responseData );
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

    public function applyJob(ApplyJobRequest $request){

        $providerDetail = Provider::where('user_id',Auth::user()->id)->first();
        $responseData   = [];

        if($providerDetail->status!='approved'){

            $message        = __('messages.unapproved_provider');
            $status_code    = 400;
            $status         = False;

        }else{

            $jobDetail = RestaurantJob::where('uuid',$request->job_id)->first('id');
            $providerAppliedJob = JobApplication::where(['provider_id'=>$providerDetail->id,'job_id'=>$jobDetail->id])->first();

            if($providerAppliedJob){
                return common_response( __('messages.already_applied'), False, 402, [] );
            }

            $data = array(
                'provider_id'   =>  $providerDetail->id,
                'job_id'        =>  $jobDetail->id,
                'rate_type'     =>  $request->rate_type,
                'rate'          =>  $request->rate,
                'application_status'=>'pending',
            );
            $jobApplication = new JobApplication;
            $jobApplication->create($data);

            // Email to Restaurant about Provider applied for job
            $details = [
                'title' =>  Auth::user()->first_name.' '.Auth::user()->last_name.'Provider applied for a JOb',
                'body'  =>  '',
                'subject'   => 'Job Applicant (Provider)'
            ];
            Mail::to('sunil01thakur01@gmail.com')->send(new \App\Mail\JobAppliedMail($details));

            $message        = __('messages.success');
            $status_code    = 200;
            $status         = True;

        }

        return common_response( $message, $status, $status_code, $responseData );

    }
}
