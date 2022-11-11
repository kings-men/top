<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class JobPostingRequest extends FormRequest
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
            'service_id'        =>'required|integer',
            'description'       =>'required|string',
            'schedule_type'     =>'required|string',
            'files_id.*'        =>'required|integer',
            // 'status'            =>'required|string',
            'start_at'          =>'required|date',
            'end_at'            =>'required|date',
            'restaurant_name'   =>'required|string',
            'restaurant_location'=>'required|string',
            'latitude'          =>'nullable|between:-90,90',
            'longitude'         =>'nullable|between:-180,180',

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
