<?php

namespace App\Http\Requests\Admin\Semester;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSemesterRequest extends FormRequest
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
            'semester' => ['required'],
            'year' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'semester.required' => 'Выберите семестр',
            'year.required' => 'Выберите год',
        ];
    }
}
