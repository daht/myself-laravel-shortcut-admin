<?php

namespace App\Http\Requests\AdminApi;

use App\Rules\AdminRouteUrlCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class SystemPermissionsCreateRequest extends FormRequest
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
            'parent_id' => 'required|integer',
            'is_menu' => 'required|integer',
            'name' => 'required',
            'url' => ['required', new AdminRouteUrlCheckRule()],
            'method' => 'required|integer',
            'sort' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'parent_id.required' => ':attribute不能为空',
            'parent_id.integer' => ':attribute错误',
            'is_menu.required' => ':attribute不能为空',
            'is_menu.integer' => ':attribute范围不准确',
            'name.required' => ':attribute不能为空',
            'url.required' => ':attribute不能为空',
            'method.required' => ':attribute不能为空',
            'method.integer' => ':attribute错误',
            'sort.required' => ':attribute不能为空',
            'sort.integer' => ':attribute错误',
        ];
    }

    public function attributes()
    {
        return [
            'parent_id' => '上级权限',
            'is_menu' => '权限类型',
            'name' => '权限名称',
            'url' => '权限路由',
            'method' => '请求类型',
            'sort' => '排序',
        ];
    }
}
