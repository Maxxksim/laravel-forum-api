<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Post extends Model
{

    use HasFactory;

    protected $fillable = [
        'name_image',
        'title',
        'text',
        'user_id',
        'author_first_name',
        'author_last_name',
        'likes'
    ];

    protected $hidden = [
        'updated_at'
    ];

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
    }

    public static function generateNameImage(string $extension): string
    {
        return  auth()->id() . '_' . now()->format('ymdhisv') . '.' . $extension;
    }
}
