<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'id' => ['nullable'],
            'name' => ['required'],
            'descricao' => ['nullable'],
            'severity' => ['nullable'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'nome do projeto é obrigatorio',
            'start_at.date' => 'formato da data invalida',
            'end_at.date' => 'formato da data invalida'
        ];
    }
}
