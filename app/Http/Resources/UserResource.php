<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
        $image_path = $this->resource->userInfo->image ?? $this->NO_IMAGE;

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'comment' => $this->resource->userInfo->comment,
            'image' => asset('storage/'.$image_path),
            'followFlg' => $authUser->follows()->where('followed_id', $this->resource->id)->exists(),
        ];
    }
}
