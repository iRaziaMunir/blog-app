<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class deleteCommentRequest extends FormRequest
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
            'commentable_type' => 'required|in:Post,Video,Image',
            'commentable_id' => 'required|integer|exists:' . $this->commentable_type . ',id',
        ];
    }

    public function messages()
    {
        return [
            'commentable_type.required' => 'A valid commentable type is required (Post, Video, or Image).',
            'commentable_type.in' => 'The commentable type must be either Post, Video, or Image.',
            'commentable_id.required' => 'A valid ID for the content is required.',
            'commentable_id.exists' => 'The selected content does not exist.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            "validation errors" => $errors
        ], 422);

        throw new HttpResponseException ($response);
    }
}
