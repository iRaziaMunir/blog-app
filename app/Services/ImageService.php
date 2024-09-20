<?php
namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
  public function postImage($data)
  {
    if(isset($data['image']) && $data['image']->isValid())
    {
      $imagePath = $data['image']->store('images', 'public');
    // Storage::put('','');
    return Image::create([
      'image' => $imagePath,
      'description' => $data['description'],
      'author_id' => $data['author_id']
    ]);
    }
  }
}
