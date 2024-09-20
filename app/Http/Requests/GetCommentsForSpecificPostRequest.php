<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetCommentsForSpecificPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'commentable_type.required' => 'Commentable type is required',
            'commentable_type.required' => 'Commentable type mus be a string',
            'commentable_id.required' => 'Commentable id is required',
            'commentable_id.required' => 'Commentable id must be an integer'
        ];   
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'Validation errors'=> $errors
        ]);

        throw new HttpResponseException($response);
    }
}
