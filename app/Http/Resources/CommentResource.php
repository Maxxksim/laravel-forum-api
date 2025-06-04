<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'comment' => $this->comment,
            'author_first_name' => $this->author_first_name,
            'author_last_name' => $this->author_last_name,
            'user_id' => $this->user_id,
            'comment_id' => $this->id
        ];
    }
}
