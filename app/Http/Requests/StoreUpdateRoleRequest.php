<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUpdateRoleRequest extends FormRequest
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
        $id = isset(request()->id) ? request()->id : 'NULL';

        $rules = [
            'name' => "required|max:255|unique:roles,name,{$id},id,deleted_at,NULL",
        ];

        $groupUserId = request()->groupUserId;
        if (is_array($groupUserId)) {
            foreach ($groupUserId as $key => $value) {
                $rules['groupUserId.' . $key] = 'required|max:36';
            }
        } else {
            $rules['groupUserId'] = 'required|array';
        }

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
