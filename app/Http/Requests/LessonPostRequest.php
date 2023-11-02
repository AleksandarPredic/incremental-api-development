<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LessonPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'  => 'required',
            'body'   => 'required',
            'active' => 'required|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()
                ->json([
                    'error' => [
                        'message' => 'Validation errors',
                    ],
                    'data' => $validator->errors()
                ])
                ->setStatusCode(400),
            );
    }

    public function messages()
    {
        return [
            'title' => 'The title parameter is required.',
            'body' => 'The body parameter is required.',
            'active' => 'The active parameter is required.',
        ];
    }
}
