<?php

namespace App\Http\Requests\AdminApi;

use Illuminate\Foundation\Http\FormRequest;

class SystemAdminUpdateRequest extends FormRequest
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
            'password' => 'nullable|confirmed|min:6',
            'original_password' => 'required|password',
        ];
    }

    public function messages()
    {
        return [
            'admin_id.required' => ':attribute不能为空',
            'admin_id.integer' => ':attribute错误',
            'password.min' => ':attribute长度不能低于6位',
            'password.confirmed' => ':attribute两次输入不一致',
            'original_password.required' => ':attribute不能为空',
            'original_password.password' => ':attribute提供不正确',
        ];
    }

    public function attributes()
    {
        return [
            'admin_id' => '管理员ID',
            'password' => '管理员密码',
            'original_password' => '操作管理员密码',
        ];
    }
}
