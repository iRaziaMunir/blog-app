<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => 'required|string|max:1000',
            'commentable_type' => 'required|in:Post,Video,Image',
            'commentable_id' => 'required|integer',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('commentable_id',[
            Rule::exists($this->getTableForType(), 'id')
        ],
        function($input)
        {
            return in_array($input->commentable_type, ['Post', 'Video', 'image']);
        }
        );
    }

    protected function getTableForType()
    {
        switch ($this->commentable_type) {
            case 'Post':
                return 'posts';
            case 'Video':
                return 'videos';
            case 'Image':
                return 'images';
            default:
                return null;
        }
    }

    public function messages()
    {
        return [
            'commentable_type.required' => 'A valid commentable type is required (Post, Video, or Image).',
            'commentable_type.in' => 'The commentable type must be one of Post, Video, or Image.',
            'commentable_id.required' => 'A valid ID for the post, video, or image is required.',
            'commentable_id.exists' => 'The commentable ID does not exist for the given type.',
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

