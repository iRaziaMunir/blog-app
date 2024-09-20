<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function postImage(ImageRequest $request)
    {
        $data = $request->all();
        $data['author_id'] = Auth::id();

        $image = $this->imageService->postImage($data);
        // $image
        //     ? ResponseHelper::success($image, 'Image uploaded Successfully!', 201)
        //     : ResponseHelper::error('Image Uploading Failed', 400);

            if ($image) 
            {
                return ResponseHelper::success($image, 'image Uploaded successfully', 201);
            }
            else
            {
                return ResponseHelper::error('image Uploading failed',400 );
            }
    }
}
