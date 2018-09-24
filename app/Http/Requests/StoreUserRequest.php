<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:8',
        ];

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $json = [
            'status' => 1,
            "message" => "The given data was invalid.",
            'errors' => $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($json, 422));
    }
}
