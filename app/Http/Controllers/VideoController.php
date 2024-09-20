<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\VideoRequest;
use App\Services\VideoService;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
         $this->videoService = $videoService;
    }

    public function postVideo(VideoRequest $request)
    {
        $data = $request->all();
        $data['author_id'] = Auth::id();

        $video = $this->videoService->postVideo($data);

        if ($video) 
            {
                return ResponseHelper::success($video, 'video Uploaded successfully', 201);
            }
            else
            {
                return ResponseHelper::error('video Uploading failed',400 );
            }
    }
}
