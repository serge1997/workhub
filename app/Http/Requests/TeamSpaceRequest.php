<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamSpaceRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'description' => ['nullable']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'nome é obrigatorio'
        ];
    }

    public function name() : string
    {
        return $this->name;
    }
    public function description() : ?string
    {
        return $this->description;
    }
}
