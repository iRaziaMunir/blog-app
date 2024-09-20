<?php
namespace App\Services;

use App\Models\Post;

class PostService
{
  public function createPost($data)
  {
    return Post::create([

      'title' => $data['title'],
      'body' => $data['body'],
      'author_id' => $data['author_id']
    ]);
  }
}
