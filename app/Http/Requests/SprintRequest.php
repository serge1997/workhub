<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SprintRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'desc' => ['nullable'],
            'start_at' => ['nullable'],
            'close_at' => ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "sprint name is required"
        ];
    }

    public function name() : string
    {
        return $this->name;
    }
}
