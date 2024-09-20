<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VideoRequest extends FormRequest
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
            'video' => 'required|file|mimetypes:video/mp4,video/x-msvideo,video/quicktime|max:10240',
            'title' => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The video title is required.',
            'video.required' => 'Please upload a video file.',
            'video.mimetypes' => 'The video must be in mp4, avi, or quicktime format.',
            'video.max' => 'The video size cannot exceed 10MB.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'Validation Error' => $errors,
        ], 422);

        throw new HttpResponseException($response);
    }
}
