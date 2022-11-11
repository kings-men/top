<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
Use Auth;

class ProviderProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'bussiness_name'    =>'Required|string',
            'address'           =>'Required|string',
            'city'              =>'Required|string',
            'state_id'          =>'Required|integer',
            'contact_number'    =>'Required|string|max:20',
            'email'             =>'Required|string|max:255',
            'dob'               =>'Required',
            'ssn'               =>'Required|string',
            'experience_years'  =>'Required|integer',
            'education'         =>'Required|string',
            'previous_employer' =>'Nullable|string',
            'referral'          =>'Nullable|string',
            'trade_education'   =>'Required|string',
            'bio'               =>'Required|string',
            'hourly_rate'       =>'Required|integer',
            'weekend_rate'      =>'Required|integer',
            'preferred_distance'=>'Required|integer',
            'Insurance'         =>'Nullable|string',
            'trade_organization'=>'Nullable|string'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        if ( request()->is('api*')){
            $data = [
                'status' => 'false',
                'message' => $validator->errors()->first(),
                'all_message' =>  $validator->errors()
            ];

            throw new HttpResponseException(response()->json($data,422));
        }

        throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
    }

}
