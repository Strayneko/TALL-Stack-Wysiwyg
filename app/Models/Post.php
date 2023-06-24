<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $guarded = ['id'];

    public function getPostExcerpt()
    {
        if (is_null($this->body)) return '-';
        return Str::of($this->body)->stripTags()->limit(30);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::updating(function (Post $post) {
            // update the slug when the title is changed
            if ($post->isDirty('title')) {
                $post->slug = SlugService::createSlug(Post::class, 'slug', $post->title);
            }
        });
    }
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
