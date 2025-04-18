<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'old_password.required' => '旧パスワードは必須です。',
            'old_password.min' => '旧パスワードは8文字以上である必要があります。',
            'new_password.required' => '新パスワードは必須です。',
            'new_password.min' => '新パスワードは8文字以上である必要があります。',
            'new_password.confirmed' => 'パスワード確認と一致しません。',
        ];
    }
}
