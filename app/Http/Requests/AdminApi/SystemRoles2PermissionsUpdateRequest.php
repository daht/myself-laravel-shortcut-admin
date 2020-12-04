<?php

namespace App\Http\Requests\AdminApi;

use Illuminate\Foundation\Http\FormRequest;

class SystemRoles2PermissionsUpdateRequest extends FormRequest
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
            'role_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => ':attribute不能为空',
            'role_id.integer' => ':attribute错误',
        ];
    }

    public function attributes()
    {
        return [
            'role_id' => '角色ID',
        ];
    }
}
