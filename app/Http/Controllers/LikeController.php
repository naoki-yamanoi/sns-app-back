<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function createLike(Request $request)
    {
        $user = Auth::user();
        $user->likes()->attach($request->post_id);
    }

    public function deleteLike(Request $request)
    {
        $user = Auth::user();
        $user->likes()->detach($request->post_id);
    }
}
