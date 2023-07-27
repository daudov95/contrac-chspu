<?php

namespace App\Http\Requests\Admin\Table;

use Illuminate\Foundation\Http\FormRequest;

class StoreTableRequest extends FormRequest
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
            'short_name' => ['required', 'min:5'],
            'semester_id' => ['required', 'exists:semesters,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Введите наименование таблицы",
            'short_name.required' => "Введите короткое наименование таблицы",
            'semester_id.required' => "Выберите семестер",
        ];
    }
}
