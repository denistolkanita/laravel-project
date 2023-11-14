<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts', compact('posts'));
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $postsArr = [
            [
                'title' => 'Title - 1',
                'content' => 'Content - 1',
                'image' => 'image-1.jpg',
                'likes' => 25,
                'is_published' => true,
            ],
            [
                'title' => 'Title - 2',
                'content' => 'Content - 2',
                'image' => 'image-2.jpg',
                'likes' => 26,
                'is_published' => true,
            ]
        ];

        foreach ($postsArr as $post) {
            Post::create($post);
        }

        dd('created');
    }

    public function update(): void
    {
        $post = Post::find(2);
        $post->update([
            'title' => 'update',
            'content' => 'update',
            'image' => 'update',+
            'likes' => 26,
        ]);

        dd('updated');
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
