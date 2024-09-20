<?php
namespace App\Services;

use App\Models\Video;

class VideoService
{
  public function postVideo($data)
  {

    if( isset( $data['video'] ) && $data['video']->isValid() )
    {
      $videoPath = $data['video']->store('videos', 'public');
    
      return Video::create([

        'title' => $data['title'],
        'description' => $data['description'],
        'video' => $videoPath,
        'author_id' => $data['author_id']
      ]);
    }
  }
}
