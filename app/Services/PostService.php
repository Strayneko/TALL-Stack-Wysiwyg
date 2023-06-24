<?php

namespace App\Services;

use Exception;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{

    public function __construct(private Post $post)
    {
    }

    public function query(): Builder
    {
        return $this->post->query();
    }

    // in this method you can use different method of storing data by passing data parameter with array or the model itself
    public function store(null | Post | array $data): Post
    {
        if (is_null($data)) {
            throw new Exception('Data should not be null!');
        }

        try {
            if ($data instanceof Post) {
                $data->user_id = auth()->user()?->id;
                $data->save();
                return $data;
            }

            return $this->post->create($data);
        } catch (Exception $e) {
            throw new Exception("Failed to store the post, reason: {$e->getMessage()}");
        }
    }

    public function getPosts(bool $isPaginate = false, int $pagination = 10, bool $asQuery = false): Collection | LengthAwarePaginator | null
    {
        $query = $this->query()->with('author')->latest();

        if ($isPaginate) return $query->paginate($pagination);
        return $query->get();
    }

    public function findOne(string $slug): ?Post
    {
        $post = $this->query()->with('author')->where('slug', $slug)->first();
        if (is_null($post)) {
            throw new Exception("No post found with slug = {$slug}");
        }

        return $post;
    }

    public function update(null | Post | array $data, ?string $slug = null)
    {
        if (is_null($data)) {
            throw new Exception('Please provice update data!');
        }

        try {
            if ($data instanceof Post) {
                $data->save();
                return $data;
            }

            $this->findOne($slug)->update($data);
        } catch (Exception $e) {
            throw new Exception("Failed to execute the query, reason : {$e->getMessage()}");
        }
    }

    public function delete(?string $slug, bool $forceDelete = false): ?bool
    {
        try {
            return $this->findOne($slug)->delete();
        } catch (Exception $e) {
            throw new Exception("Failed to execute the query, reason: {$e->getMessage()}");
        }
    }
}
