<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreUser extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            // 'phone'=>['required',env('RULE_PHONE')],
            // 'name' => 'required|min:3|max:20',
            // 'password' => 'required|min:6|max:20',
            // 'password2' => 'same:password',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '昵称不能为空',
            'name.min' => '昵称不能小于3位数',
            'name.max' => '昵称不能大于20位数',
            'password.required' => '密码不能为空',
            'password.min' => '密码不能小于6位数',
            'password.max' => '密码不能大于20位数',
            'password2.same' => '两次密码不一致,请重新输入',
            'phone.required' => '手机号不能为空',
            'phone.regex' => '请输入正确的手机号码',
        ];
    }
}
