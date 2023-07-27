<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'id' => ['required', 'exists:users'],
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email'],
            'password' => ['nullable', 'alpha_dash', 'min:6'], // решить вопрос с пробелами
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
            'password.without_spaces' => 'Whitespace not allowed.',
            'rank.required' => "Введите должность",
            'rank.min' => "Должность должен содержать не менее 5 символов",
            'table_id.required' => "Выберите категорию",
        ];
    }
}
