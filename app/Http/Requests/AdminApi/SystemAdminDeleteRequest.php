<?php

namespace App\Http\Requests\AdminApi;

use Illuminate\Foundation\Http\FormRequest;

class SystemAdminDeleteRequest extends FormRequest
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

    public function rules()
    {
        return [
            'admin_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'admin_id.required' => ':attribute不能为空',
            'admin_id.integer' => ':attribute错误',

        ];
    }

    public function attributes()
    {
        return [
            'admin_id' => '管理员ID',
        ];
    }
}
