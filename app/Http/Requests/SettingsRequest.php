<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['sometimes', 'nullable', 'regex:/^[A-Za-z0-9_]+$/', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Это обязательное поле',
            'email.required' => 'Это обязательное поле',
            'email.email' => 'Некорректный E-mail адреса',
            'password.required' => 'Это обязательное поле',
            'password.min' => 'Пароль должен содержать минимум 6 символов',
            'password.regex' => 'Пароль должен содержать только латинские буквы и цифры',
        ];
    }
}
