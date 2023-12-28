<?php

namespace App\Services\Post;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class Service
{
    public function store(array $data)
    {
        try {
            Db::beginTransaction();
            $category = $data['category'];
            $tags = $data['tags'];
            unset($data['tags'], $data['category']);

            $data['category_id'] = $this->getCategoryId($category);
            $tagIds = $this->getTagIds($tags);

            $post = Post::create($data);
            $post->tags()->attach($tagIds);

            Db::commit();
        } catch (\Exception $exception) {
            Db::rollBack();

            return $exception->getMessage();
        }


        return $post;
    }

    public function update(Post $post, $data)
    {
        try {
            Db::beginTransaction();
            $category = $data['category'];
            $tags = $data['tags'];
            unset($data['tags'], $data['category']);

            $data['category_id'] = $this->getCategoryIdWithUpdate($category);
            $tagIds = $this->getTagIdsWithUpdate($tags);

            $post->tags()->sync($tagIds);
            $post->update($data);
        } catch (\Exception $exception) {
            Db::rollBack();

            return $exception->getMessage();
        }

        return $post->fresh();
    }

    private function getTagIds($tags): array
    {
        $tagIds = [];

        foreach ($tags as $tag) {
            $tag = !isset($tag['id']) ? Tag::create($tag) : Tag::find($tag['id']);
            $tagIds[] = $tag;
        }

        return $tagIds;
    }

    private function getTagIdsWithUpdate($tags): array
    {
        $tagIds = [];

        foreach ($tags as $tag) {
            if (!isset($tag['id'])) {
                $tag = Tag::create($tag);
            } else {
                $currentTag = Tag::find($tag['id']);
                $currentTag->update($tag);
                $tag = $currentTag->fresh();
            }

            $tagIds[] = $tag->id;
        }

        return $tagIds;
    }

    private function getCategoryId($item): int
    {
        $category = !isset($item['id']) ? Category::create($item) : Category::find($item['id']);

        return $category->id;
    }

    private function getCategoryIdWithUpdate($item): int
    {
        if (!isset($item['id'])) {
            Category::create($item);
        } else {
            $category = Category::find($item['id']);
            $category->update($item);
            $category = $category->fresh();
        }

        return $category->id;
    }
}
