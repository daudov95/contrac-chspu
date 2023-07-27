<?php

namespace App\Http\Requests\Admin\Table\Question;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'id' => ['required'],
            'text' => ['required'],
            'options' => ['required'],
            'type' => ['required'],
            'curator_id' => ['required'],
            'order' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'table_id.required' => "ID таблицы обязателен",
            'text.required' => "Введите текст",
            'options.required' => "Введите варианты",
            'type.required' => "Выберите вид деятельности",
            'curator_id.required' => "Выберите куратора",
            'order.required' => "Введите позицию в таблице",
        ];
    }
}
