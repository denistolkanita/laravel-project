<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $posts = Post::paginate(5);

        return view('posts.index', compact('posts'));
    }
}
