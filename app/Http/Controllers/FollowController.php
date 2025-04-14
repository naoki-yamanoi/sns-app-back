<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function createFollow(Request $request)
    {
        $user = Auth::user();
        $user->follows()->attach($request->followed_id);
    }

    public function deleteFollow(Request $request)
    {
        $user = Auth::user();
        $user->follows()->detach($request->followed_id);
    }
}
