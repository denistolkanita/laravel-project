<?php

namespace App\Http\Controllers\Admin\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $postsCount = Post::all()->count();

        return view(
            'admin.post.create',
            compact('categories', 'tags', 'postsCount')
        );
    }
}
