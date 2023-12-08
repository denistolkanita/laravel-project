<?php

namespace App\Http\Controllers\Admin\Post;

use App\Models\Post;

class ShowController extends BaseController
{
    public function __invoke(Post $post)
    {
        $postsCount = Post::all()->count();

        return view('admin.post.show', compact('post', 'postsCount'));
    }
}
