<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostMineResource extends JsonResource
{
    private $NO_IMAGE = 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $authUser = Auth::user();
        $image_path = $this->resource->user->userInfo->image ?? $this->NO_IMAGE;

        return [
            'id' => $this->resource->id,
            'userId' => $this->resource->user->id,
            'userName' => $this->resource->user->name,
            'content' => $this->resource->post,
            'userImage' => asset('storage/'.$image_path),
            'likeFlg' => $authUser->likes()->where('post_id', $this->resource->id)->exists(),
            'createdAt' => $this->resource->created_at->format('Y-m-d H:i'),
        ];
    }
}
