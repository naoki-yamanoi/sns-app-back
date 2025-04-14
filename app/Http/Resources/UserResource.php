<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
            'name' => $this->resource->name,
            'comment' => $this->resource->userInfo->comment,
            'image' => $this->resource->userInfo->image,
            'followFlg' => $authUser->follows()->where('followed_id', $this->resource->id)->exists(),
        ];
    }
}
