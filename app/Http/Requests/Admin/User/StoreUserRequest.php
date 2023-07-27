<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'rank' => ['required', 'min:5'],
            'table_id' => ['required', 'exists:tables,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Введите ФИО",
            'name.min' => "ФИО должно содержать не менее 5 символов",
            'email.required' => "Введите E-mail",
            'email.email' => "Неправильный E-mail адрес",
            'password.required' => "Введите пароль",
            'password.min' => "Пароль должен содержать не менее 6 символов",
            'rank.required' => "Введите должность",
            'rank.min' => "Должность должен содержать не менее 5 символов",
            'table_id.required' => "Выберите категорию",
        ];
    }
}
