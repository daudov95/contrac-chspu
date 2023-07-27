<?php

namespace App\Http\Requests\Admin\Curator;

use Illuminate\Foundation\Http\FormRequest;

class StoreCuratorRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите имя',
            'user_id.required' => 'Выберите пользователя',
        ];
    }
}
