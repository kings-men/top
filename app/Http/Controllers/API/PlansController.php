<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plans;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index(Request $request){

        $responseData   =   Plans::with('features','features.feature')->get();
        $message        =   __('messages.plans_retrieved_successfully');
        $status_code    =   200;
        $status         =   True;

        return common_response( $message, $status, $status_code, $responseData );
    }
}
