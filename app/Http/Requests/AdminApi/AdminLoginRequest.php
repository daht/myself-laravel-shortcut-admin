<?php

namespace App\Http\Requests\AdminApi;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'mobile' => 'required',
            'password' => 'required',
            'captcha_code' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'mobile.required' => ':attribute不能为空',
            'password.required' => ':attribute不能为空',
            'captcha_code.required' => ':attribute不能为空',
            'captcha_code.captcha' => ':attribute错误',
        ];
    }

    public function attributes()
    {
        return [
            'mobile' => '手机号',
            'password' => '密码',
            'captcha_code' => '验证码',
        ];
    }
}
