<?php

namespace App\Http\Requests\Admin\Document;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
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
            'name' => ['required', 'min:3'],
            'document' => ['required', 'file', 'mimes:doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите имя документа',
            'name.min' => 'Имя должно содержать не менее 3-х символов',
            'document.required' => 'Прикрепите документ',
            'document.mimes' => 'Неверный формат файла. Допустимые форматы [doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip]',
        ];
    }
}
