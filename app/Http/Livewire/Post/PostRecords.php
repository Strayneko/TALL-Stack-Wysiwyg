<?php

namespace App\Http\Livewire\Post;

use App\Services\PostService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class PostRecords extends Component
{
    use WithPagination;

    private PostService $postService;

    public function boot(PostService $postService): void
    {
        $this->postService = $postService;
    }

    public function render()
    {
        $posts = $this->postService->getPosts(true);
        return view('livewire.post.post-records', compact('posts'));
    }
}
