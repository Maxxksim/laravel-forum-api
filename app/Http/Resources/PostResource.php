<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_image' => $this->name_image,
            'title' => $this->title,
            'text' => $this->text,
            'author_first_name' => $this->author_first_name,
            'author_last_name' => $this->author_last_name,
            'user_id' => $this->user_id,
            'likes' => $this->likes,
            'comments' => $this->comments()->get()->toResourceCollection(),
            'created_at' => $this->created_at->format('Y-m-d H:i')
        ];
    }
}
