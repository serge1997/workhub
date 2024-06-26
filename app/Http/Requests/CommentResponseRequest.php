<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentResponseRequest extends FormRequest
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
            "response" => ["required"],
            "task_id" => ["required"],
            "comment_id" => ["required"]
        ];
    }

    public function response()
    {
        return $this->response;
    }

    public function task()
    {
        return $this->task_id;
    }

    public function comment()
    {
        return $this->comment_id;
    }
}
