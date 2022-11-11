<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class RestaurantProfileRequest extends FormRequest
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
        $id = request()->id;

        return [
            'logo_file_id'  =>'required|integer',
            'restaurant_name'   =>'required|string|max:255',
            'address'           =>'nullable|max:255|string',
            'city'              =>'required|string|max:100',
            'state_id'          =>'required|integer',
            'phone_number'      =>'required|integer',
            'email'             =>'required|email|max:255',
            'cusine.*'            =>'nullable|integer',
            'restaurant_type'   =>'nullable|max:255|string',
            'seats'             =>'nullable',
            'bar'               =>'nullable',
            'referred_by'       =>'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ( request()->is('api*')){
            $data = [
                'status' => 'false',
                'status_code' => 422,
                'message' => $validator->errors()->first(),
                'all_message' =>  $validator->errors()
            ];

            throw new HttpResponseException(response()->json($data,422));
        }

        throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
    }

}
