<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'author_first_name',
        'author_last_name',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
