<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Service;
use App\Http\Requests\UserRequest;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\ProviderProfileRequest;
use App\Http\Requests\CuisineRequest;
use App\Http\Requests\OtpPostRequest;
use App\Http\Requests\ProviderBankDetailRequest;
use Validator;
use Hash;
Use Auth;
use App\Http\Resources\API\UserResource;
use App\Http\Resources\API\ServiceResource;
use Illuminate\Support\Facades\Password;
use App\Models\Booking;
use Illuminate\Support\Facades\Crypt;
use App\Models\Provider;
use App\Models\Cuisine;
use App\Models\WorkExperience;
use App\Models\Skills;
use App\Models\Otp;
use App\Models\UserRole;
use App\Models\ProviderDocument;
use App\Models\Documents;
use App\Models\ProviderBank;
use App\Models\HandymanRating;
use App\Models\ProviderSubscription;
use App\Models\BookingHandymanMapping;
use App\Http\Resources\API\HandymanRatingResource;
use App\Models\Company;
use Customers;

class UserController extends Controller
{

    public function __construct() {
        $this->roles = array('restaurant','provider');
     }

    public function saveProviderBank(ProviderBankDetailRequest $request){

        $user = Auth::user();
        $input = $request->all();

        $data = array(
            'account_type' => Crypt::encryptString($input['account_type']),
            'iban' => Crypt::encryptString($input['iban']),
            'bic' => Crypt::encryptString($input['bic']),
            'currency_type' => Crypt::encryptString($input['currency_type'])
        );

        try {

            $providerId = Provider::where('user_id',$user->id)->first('id');
            ProviderBank::updateOrCreate(['provider_id'=>$providerId->id],$data);

          } catch (\Exception $e) {

            return [
                'status' => False,
                'message' => $e
            ];
          }

        $message = __('messages.updated');
        $response = [
            'status' => True,
            'message' => $message
        ];

        return comman_custom_response( $response );
    }

    public function login(){

        if(empty(request('role')) && !in_array(request('role'),$this->roles) ){
            return common_response( trans('auth.failed'), False, 400, $data=[] );
        }

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){

            $user = Auth::user();
            $user->save();

            $roleDetail = UserRole::where('user_id',$user->id)->with('roleDetail')->first();

            if($roleDetail->roleDetail->name!=request('role')){
                return common_response( trans('auth.failed'), False, 400, $data=[] );
            }

            if($roleDetail->roleDetail->name=='restaurant'){

                $filter = array('uuid','display_name');
                $profile = Company::where('user_id',$user->id)->with('file')->first();
                $profile_image = !isset($profile->file->name) ? Null : $profile->file->name;

            }else{

                $filter = array('uuid','first_name','last_name');
                $profile = Provider::join('provider_documents','provider_documents.provider_id','=','providers.id')
                            ->join('files','files.id','=','provider_documents.id')
                            ->where('provider_documents.document_type','provider_profile_picture')->select('name')->first();
                $profile_image = $profile_image = !isset($profile['name']) ? Null : $profile['name'];
            }

            $success = User::where('id',$user->id)->with('state')->with('country')->select($filter)->first();
            $success['api_token'] = $user->createToken('auth_token')->plainTextToken;
            $success['profile_image'] = $profile_image;
            $success['role']   =   $roleDetail->roleDetail->name;

            return common_response( trans('messages.login_success'), True, 200, $success );

        }
        else{

            return common_response( trans('auth.failed'), False, 400, $data=[] );
        }
    }

    public function userList(Request $request)
    {
        $user_type = isset($request['user_type']) ? $request['user_type'] : 'handyman';

        $handyman_list = User::where('user_type',$user_type)->where('status',1)->withTrashed();
        if($request->has('provider_id'))
        {
            $handyman_list = $handyman_list->where('provider_id',$request->provider_id);
        }
        if($request->has('city_id') && !empty($request->city_id))
        {
            $handyman_list = $handyman_list->where('city_id',$request->city_id);
        }
        if($request->has('status') && isset($request->status))
        {
            $handyman_list = $handyman_list->where('status',$request->status);
        }

        if($request->has('booking_id')){
            $booking_data = Booking::find($request->booking_id);

            $service_address = $booking_data->handymanByAddress;
            if($service_address != null)
            {
                $handyman_list = $handyman_list->where('service_address_id', $service_address->id);
            }
        }
        $per_page = config('constant.PER_PAGE_LIMIT');
        if( $request->has('per_page') && !empty($request->per_page)){
            if(is_numeric($request->per_page)){
                $per_page = $request->per_page;
            }
            if($request->per_page === 'all' ){
                $per_page = $handyman_list->count();
            }
        }

        $user_list = $handyman_list->paginate($per_page);

        $items = UserResource::collection($user_list);

        $response = [
            'pagination' => [
                'total_items' => $items->total(),
                'per_page' => $items->perPage(),
                'currentPage' => $items->currentPage(),
                'totalPages' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
                'next_page' => $items->nextPageUrl(),
                'previous_page' => $items->previousPageUrl(),
            ],
            'data' => $items,
        ];

        return comman_custom_response($response);
    }

    public function userDetail(Request $request)
    {
        $id = $request->id;

        $user = User::find($id);
        $message = __('messages.detail');
        if(empty($user)){
            $message = __('messages.user_not_found');
            return comman_message_response($message,400);
        }

        $service = [];
        if($user->user_type == 'provider')
        {
            $service = Service::where('provider_id',$id)->where('status',1)->orderBy('id','desc')->paginate(10);
            $service = ServiceResource::collection($service);
        }
        $user_detail = new UserResource($user);
        $handyman_rating = [];
        if($user->user_type == 'handyman'){
            $handyman_rating = HandymanRating::where('handyman_id',$id)->orderBy('id','desc')->paginate(10);
            $handyman_rating = HandymanRatingResource::collection($handyman_rating);
        }

        $response = [
            'data' => $user_detail,
            'service' => $service,
            'handyman_rating_review' => $handyman_rating
        ];
        return comman_custom_response($response);

    }

    public function verifyOtp(Request $request){

        $response = (new Otp)->verifyOtp($request->email,$request->otp);
        return common_response( $response['message'], $response['status'], $response['status_code'], $response['data'] );
    }

    public function changePassword(Request $request){
        $user = User::where('id',\Auth::user()->id)->first();

        if($user == "") {
            $message = __('messages.user_not_found');
            return comman_message_response($message,400);
        }

        $hashedPassword = $user->password;

        $match = Hash::check($request->old_password, $hashedPassword);

        $same_exits = Hash::check($request->new_password, $hashedPassword);
        if ($match)
        {
            if($same_exits){
                $message = __('messages.old_new_pass_same');
                return comman_message_response($message,400);
            }

			$user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            $message = __('messages.password_change');
            return comman_message_response($message,200);
        }
        else
        {
            $message = __('messages.valid_password');
            return comman_message_response($message);
        }
    }

    public function logout(Request $request){
        $user = Auth::user();

        if($request->is('api*')){
            $user->player_id = null;
            $user->save();
            return comman_message_response('Logout successfully');
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => __($response), 'status' => true, 'status_code' => 200])
            : response()->json(['message' => __($response), 'status' => false, 'status_code' => 400]);
    }

    public function createNewPassword(OtpPostRequest $request){

        $email = $request->email;
        $token = $request->token;
        $data = [];

        $row = Otp::where(['token'=>$token,'identifier'=>$email])->first();

        if($row){

            $UpdatePassword = User::where('email', $request->email)->update(['password'=>Hash::make($request->password)]);

            if($UpdatePassword){
                Otp::where(['identifier'=>$request->email])->delete();
            }

            $message = trans('messages.success_password_created');
            $status = True;
            $status_code = 200;
        }else{

            $message = trans('messages.failed');
            $status = False;
            $status_code = 400;
        }

        return common_response( $message, $status, $status_code, $data);
    }

    public function socialLogin(Request $request)
    {
        $input = $request->all();

        if($input['login_type'] === 'mobile'){
            $user_data = User::where('username',$input['username'])->where('login_type','mobile')->first();
        }else{
            $user_data = User::where('email',$input['email'])->first();

        }


        if( $user_data != null ) {
            if( !isset($user_data->login_type) || $user_data->login_type  == '' ){
                if($request->login_type === 'google'){
                    $message = __('validation.unique',['attribute' => 'email' ]);
                } else {
                    $message = __('validation.unique',['attribute' => 'username' ]);
                }
                return comman_message_response($message,400);
            }
            $message = __('messages.login_success');
        } else {

            if($request->login_type === 'google')
            {
                $key = 'email';
                $value = $request->email;
            } else {
                $key = 'username';
                $value = $request->username;
            }

            $trashed_user_data = User::where($key,$value)->whereNotNull('login_type')->withTrashed()->first();

            if ($trashed_user_data != null && $trashed_user_data->trashed())
            {
                if($request->login_type === 'google'){
                    $message = __('validation.unique',['attribute' => 'email' ]);
                } else {
                    $message = __('validation.unique',['attribute' => 'username' ]);
                }
                return comman_message_response($message,400);
            }

            if($request->login_type === 'mobile' && $user_data == null ){
                $otp_response = [
                    'status' => true,
                    'is_user_exist' => false
                ];
                return comman_custom_response($otp_response);
            }
            if($request->login_type === 'mobile' && $user_data != null){
                $otp_response = [
                    'status' => true,
                    'is_user_exist' => true
                ];
                return comman_custom_response($otp_response);
            }

            $password = !empty($input['accessToken']) ? $input['accessToken'] : $input['email'];

            $input['user_type']  = "user";
            $input['display_name'] = $input['first_name']." ".$input['last_name'];
            $input['password'] = Hash::make($password);
            $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'user';
            $user = User::create($input);
            $user->assignRole($input['user_type']);

            $user_data = User::where('id',$user->id)->first();
            $message = trans('messages.save_form',['form' => $input['user_type'] ]);
        }
        $user_data['api_token'] = $user_data->createToken('auth_token')->plainTextToken;
        $user_data['profile_image'] = $user_data->social_image;
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $user_data
        ];
        return comman_custom_response($response);
    }

    public function userStatusUpdate(Request $request)
    {
        $user_id =  $request->id;
        $user = User::where('id',$user_id)->first();

        if($user == "") {
            $message = __('messages.user_not_found');
            return comman_message_response($message,400);
        }
        $user->status = $request->status;
        $user->save();

        $message = __('messages.update_form',['form' => __('messages.status') ]);
        $response = [
            'data' => new UserResource($user),
            'message' => $message
        ];
        return comman_custom_response($response);
    }
    public function contactUs(Request $request){
        try {
            \Mail::send('contactus.contact_email',
            array(
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'subject' => $request->get('subject'),
                'phone_no' => $request->get('phone_no'),
                'user_message' => $request->get('user_message'),
            ), function($message) use ($request)
            {
                $message->from($request->email);
                $message->to(env('MAIL_FROM_ADDRESS'));
            });
            $messagedata = __('messages.contact_us_greetings');
            return comman_message_response($messagedata);
        } catch (\Throwable $th) {
            $messagedata = __('messages.something_wrong');
            return comman_message_response($messagedata);
        }

    }

    public function handymanReviewsList(Request $request){
        $id = $request->handyman_id;
        $handyman_rating_data = HandymanRating::where('handyman_id',$id);

        $per_page = config('constant.PER_PAGE_LIMIT');

        if( $request->has('per_page') && !empty($request->per_page)){
            if(is_numeric($request->per_page)){
                $per_page = $request->per_page;
            }
            if($request->per_page === 'all' ){
                $per_page = $handyman_rating_data->count();
            }
        }

        $handyman_rating_data = $handyman_rating_data->orderBy('created_at','desc')->paginate($per_page);

        $items = HandymanRatingResource::collection($handyman_rating_data);
        $response = [
            'pagination' => [
                'total_items' => $items->total(),
                'per_page' => $items->perPage(),
                'currentPage' => $items->currentPage(),
                'totalPages' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
                'next_page' => $items->nextPageUrl(),
                'previous_page' => $items->previousPageUrl(),
            ],
            'data' => $items,
        ];
        return comman_custom_response($response);
    }
    public function deleteUserAccount(Request $request){
        $user_id = \Auth::user()->id;
        $user = User::where('id',$user_id)->first();
        if($user == null){
            $message = __('messages.user_not_found');__('messages.msg_fail_to_delete',['item' => __('messages.user')] );
            return comman_message_response($message,400);
        }
        $user->booking()->forceDelete();
        $user->payment()->forceDelete();
        $user->forceDelete();
        $message = __('messages.msg_deleted',['name' => __('messages.user')] );
        return comman_message_response($message,200);
    }
    public function deleteAccount(Request $request){
        $user_id = \Auth::user()->id;
        $user = User::where('id',$user_id)->first();
        if($user == null){
            $message = __('messages.user_not_found');__('messages.msg_fail_to_delete',['item' => __('messages.user')] );
            return comman_message_response($message,400);
        }
        if($user->user_type == 'provider'){
            if($user->providerPendingBooking()->count() == 0){
                $user->providerService()->forceDelete();
                $user->providerPendingBooking()->forceDelete();
                $provider_handyman = User::where('provider_id',$user_id)->get();
                if(count($provider_handyman) > 0){
                    foreach ($provider_handyman as $key => $value) {
                        $value->provider_id = NULL;
                        $value->update();
                    }
                }
                $user->forceDelete();
            }else{
                $message = __('messages.pending_booking');
                 return comman_message_response($message,400);
            }
        }else{
            if($user->handymanPendingBooking()->count() == 0){
                $user->handymanPendingBooking()->forceDelete();
                $user->forceDelete();
            }else{
                $message = __('messages.pending_booking');
                 return comman_message_response($message,400);
            }
        }
        $message = __('messages.msg_deleted',['name' => __('messages.user')] );
        return comman_message_response($message,200);
    }
}
