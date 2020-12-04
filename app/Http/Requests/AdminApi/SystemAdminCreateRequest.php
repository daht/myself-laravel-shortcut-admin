<?php

namespace App\Http\Requests\AdminApi;

use App\Rules\AdminMobileCheckRule;
use App\Rules\AdminNameCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class SystemAdminCreateRequest extends FormRequest
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
            'name' => ['required', new AdminNameCheckRule()],
            'mobile' => ['required', new AdminMobileCheckRule()],
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute不能为空',
            'mobile.required' => ':attribute不能为空',
            'password.required' => ':attribute不能为空',
            'password.min' => ':attribute长度不能低于6位',
            'password.confirmed' => ':attribute两次输入不一致',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '昵称',
            'mobile' => '手机',
            'password' => '密码',
        ];
    }
}
