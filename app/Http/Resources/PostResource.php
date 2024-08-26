<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'comments_count' => $this->whenCounted('comments'),
            'created_at' => $this->created_at,
            'created_at_readable' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at,
            'updated_at_readable' => $this->updated_at->diffForHumans(),
            'image' => $this->getFirstMediaUrl('header'),
            'image_thumb' => $this->getFirstMediaUrl('header', 'thumb'),
            'user' => UserResource::make($this->whenLoaded('user')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
