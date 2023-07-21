<?php

namespace App\Api\Request\Users;

use Mine\MineApiFormRequest;

/**
 * 用户账号密码注册验证数据类.
 */
class UserRegisterRequest extends MineApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:20',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
