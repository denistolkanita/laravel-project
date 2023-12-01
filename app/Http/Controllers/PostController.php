<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
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
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(): RedirectResponse
    {
        $data = request()->validate([
            'title' => 'required|string',
            'content' => 'string',
            'image' => 'string',
            'category_id' => '',
            'tags' => ''
        ]);

        $tags = $data['tags'];
        unset($data['tags']);

        $post = Post::create($data);
        $post->tags()->attach($tags);

        return redirect()->route('post.index');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Post $post)
    {
        $data = request()->validate([
            'title' => 'string',
            'content' => 'string',
            'image' => 'string',
            'category_id' => '',
            'tags' => ''
        ]);

        $tags = $data['tags'];
        unset($data['tags']);

        $post->tags()->sync($tags);
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
    }
}
