<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\deleteCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class CommentController extends Controller
{
    protected $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    } 

   public function postComment(CommentRequest $request)
   {
    $data = $request->all();
    $data['author_id'] = Auth::id();
   
    $comment = $this->commentService->postComment($data);

    if ($comment) 
        {
            return ResponseHelper::success($comment, 'comment posted successfully', 201);
        }
        else
        {
            return ResponseHelper::error('comment posting failed',400 );
        }
   }

   public function editComment(UpdateCommentRequest $request, Comment $comment)
   {
    if(Auth::id() !== $comment->author_id)
    {
        return ResponseHelper::error('Unauthorized', 403);
    }
        $data = $request->all();
        $updatedComment = $this->commentService->editComment($comment, $data);

        return ResponseHelper::success($updatedComment, 'comment updated successfully', 200);
   }

   public function deleteComment(deleteCommentRequest $comment)
   {
    if(Auth::id() !== $comment->author_id)
    {
        return ResponseHelper::error('Unauthorized', 403);
    }

    $this->commentService->deleteComment($comment);

        return ResponseHelper::success(null, 'Comment deleted successfully', 200);
   }

   public function getCommentsFor($commentable_type, $commentable_id)
   {
    $comments = $this->commentService->getCommentsFor($commentable_type, $commentable_id);

        if (!in_array($commentable_type, ['Post', 'Video', 'Image'])) 
        {
            return ResponseHelper::error('Invalid content type', 400);
        }
        if(isEmpty($comments))
        {
            return ResponseHelper::success(null, 'No comment for this post!', 200);
        }
        return ResponseHelper::success($comments, 'Comments retrieved successfully', 200);
   }

   public function getTotalCommentsFor($commentable_type, $commentable_id)
    {
      
        if (!in_array($commentable_type, ['Post', 'Video', 'Image'])) 
        {
            return ResponseHelper::error('Invalid content type', 400);
        }

        $commentCount = $this->commentService->getTotalCommentsFor($commentable_type, $commentable_id);

        return ResponseHelper::success(['total_comments' => $commentCount], 'Comment count retrieved successfully', 200);
    }
}
