<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => ['required'],
            'execution_time' => ['required'],
            'priority' => ['required', 'max:3'],
            'user_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'titulo é obrigatorio',
            'execution_time.required' => 'Tempo de exceução é obrigatorio',
            'priority.required' => 'prioridade obrigatório',
            'priority.max' => 'prioridade inavlida',
            'user_id.required' => 'colaborador é obrigatorio'

        ];
    }
}
