<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'      => ['required'],
            'email'     => ['required'],
            'username' =>  ['required'],
            'password'  => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'nome é obrigatorio',
            'email.required'    => 'email é obrigatorio',
            'username.required' => 'username é obrigatorio',
            'password.required' => 'password é obrigatorio',
        ];
    }
}
