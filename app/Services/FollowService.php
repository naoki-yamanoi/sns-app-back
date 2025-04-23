<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class FollowService
{
    public function create($followedId)
    {
        $user = Auth::user();
        $user->follows()->attach($followedId);
    }

    public function delete($followedId)
    {
        $user = Auth::user();
        $user->follows()->detach($followedId);
    }
}
