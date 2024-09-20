<?php
namespace App\Services;

use App\Models\Comment;


class CommentService
{
  public function postComment($data)
  {
    return Comment::create([

      'body' => $data['body'],
      'commentable_id' => $data['commentable_id'],
      'commentable_type' => $data['commentable_type'],
      'author_id' => $data['author_id']
    ]);
  }

  public function editComment($comment, $data)
  {
    $comment->update([
      'body' => $data['body']
    ]);

    return $comment;
  }

  public function deleteComment($comment)
  {
    return $comment->delete();
  }

  public function getCommentsFor($commentable_type, $commentable_id)
  {
    $comment = Comment::where('commentable_type', $commentable_type)
                      ->where('commentable_id', $commentable_id)
                      ->get();
    return $comment;

  }

  public function getTotalCommentsFor($commentable_type, $commentable_id)
  {
    $comment = Comment::where('commentable_type', $commentable_type)
                      ->where('commentable_id', $commentable_id)
                      ->count();
    return $comment;

  }
}
