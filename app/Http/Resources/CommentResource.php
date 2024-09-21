<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'content' => $this->content,
            'created_at' => $this->created_at,
            'created_at_readable' => $this->created_at->diffForHumans(),
            'user' => UserResource::make($this->whenLoaded('user')),
            'children' => CommentResource::collection($this->whenLoaded('children')),
            'post' => PostResource::make($this->whenLoaded('post')),
        ];
    }
}
