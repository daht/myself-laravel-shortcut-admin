<?php

namespace App\Http\Requests\AdminApi;

use Illuminate\Foundation\Http\FormRequest;

class SystemPermissionsDeleteRequest extends FormRequest
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
            'admin_route_id' => 'required|integer',

        ];
    }

    public function messages()
    {
        return [
            'admin_route_id.required' => ':attribute不能为空',
            'admin_route_id.integer' => ':attribute错误',

        ];
    }

    public function attributes()
    {
        return [
            'admin_route_id' => '路由ID',
        ];
    }
}
