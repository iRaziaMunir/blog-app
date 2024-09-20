<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['body', 'commentable_id', 'commentable_type', 'author_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function commentable()
    {
        return $this->morphTo();
    }
}
