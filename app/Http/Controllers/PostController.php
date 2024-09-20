<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\PostRequest;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    
    public function createPost(PostRequest $request)
    {
      $data = $request->all();
      $data['author_id'] = Auth::id();
      $post =  $this->postService->createPost($data);
      
        if ($post) 
        {
            return ResponseHelper::success($post, 'Post Created successfully', 201);
        }
        else
        {
            return ResponseHelper::error('Post Creation failed',400 );
        }
    }
}

