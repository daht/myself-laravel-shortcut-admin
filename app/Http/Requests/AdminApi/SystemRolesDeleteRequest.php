<?php

namespace App\Http\Requests\AdminApi;

use Illuminate\Foundation\Http\FormRequest;

class SystemRolesDeleteRequest extends FormRequest
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
            'id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'id.required' => ':attribute不能为空',
        ];
    }

    public function attributes()
    {
        return [
            'id' => '身份ID',
            'name' => '身份名称',
        ];
    }
}
