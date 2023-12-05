<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;

class DestroyController extends Controller
{
    public function __invoke(Post $post)
    {
        $post = Post::withTrashed()->find(1);
        $post->restore();

        dd('deleted');
    }
}
