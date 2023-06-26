<?php

namespace App\Http\Livewire\Dashboard;

use App\Services\PostService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    public $posts;
    public $take = self::limit;

    private PostService $postService;
    private const limit = 6;

    public function boot(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function mount()
    {
        $this->loadPost();
    }

    public function loadPost(): void
    {
        $this->posts = $this->postService->getPosts()?->take($this->take);
    }

    public function loadMore(): void
    {
        $this->take += self::limit;
        $this->loadPost();
    }
    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
