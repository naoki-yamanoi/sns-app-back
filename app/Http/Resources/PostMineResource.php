<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostMineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $authUser = Auth::user();

        return [
            'id' => $this->resource->id,
            'userId' => $this->resource->user->id,
            'userName' => $this->resource->user->name,
            'content' => $this->resource->post,
            'userImage' => $this->resource->user->userInfo->image,
            'likeFlg' => $authUser->likes()->where('post_id', $this->resource->id)->exists(),
            'createdAt' => $this->resource->created_at->format('Y-m-d H:i'),
        ];
    }
}
