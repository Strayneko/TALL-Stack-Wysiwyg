<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;
use App\Services\PostService;
use Throwable;

class ShowPost extends Component
{
    public string $slug;
    public ?Post $post;

    private PostService $postService;

    public function boot(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function mount()
    {
        try {
            $this->post = $this->postService->findOne($this->slug);
        } catch (Throwable $e) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.post.show-post');
    }
}
