<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('posts.create');
    }

    public function store(): RedirectResponse
    {
        $data = request()->validate([
           'title' => 'string',
           'content' => 'string',
           'image' => 'string',
        ]);

        Post::create($data);

        return redirect()->route('post.index');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post)
    {
        $data = request()->validate([
            'title' => 'string',
            'content' => 'string',
            'image' => 'string',
        ]);
        $post->update($data);

        return redirect()->route('post.show', $post->id);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('post.index');
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function delete(): void
    {
        $post = Post::withTrashed()->find(1);
        $post->restore();

        dd('deleted');
    }

    public function firstOrCreate(): void
    {
        $anotherPost = [
            'title' => 'Another Title - 1',
            'content' => 'Another content',
            'image' => 'another-image.jpg',
            'likes' => 250,
            'is_published' => true,
        ];

        $post = Post::firstOrcreate(['title' => 'Another Title - 1'], $anotherPost);

        dump($post->content);
        dd('finished');
    }

    public function updateOrCreate(): void
    {
        $anotherPost = [
            'title' => 'Title - new',
            'content' => '[updateOrCreate] Another content',
            'image' => 'another-image.jpg',
            'likes' => 250,
            'is_published' => true,
        ];

        $post = Post::updateOrCreate(['title' => 'Title - new'], $anotherPost);

        dd($post->content);
    }
}
