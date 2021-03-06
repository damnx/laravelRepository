<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

class StoreUpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (isset(request()->id)) {
            return Gate::allows('UPDATE_ROLES');
        }
        return Gate::allows('CREATE_ROLES');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = isset(request()->id) ? request()->id : 'NULL';

        $rules = [
            'name' => "required|max:255|unique:roles,name,{$id},id,deleted_at,NULL",
            'groupUserId' => 'required'
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
