<?php

namespace App\Http\Controllers\Post;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request): PostResource|string
    {
        $data = $request->validated();
        $post = $this->service->store($data);

        return $post instanceof Post ? new PostResource($post) : $post;


//        return redirect()->route('post.index');
    }
}
