<?php

namespace App\Http\Livewire\Post;

use App\Services\PostService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Throwable;

class PostRecords extends Component
{
    use WithPagination;

    private PostService $postService;

    public function boot(PostService $postService): void
    {
        $this->postService = $postService;
    }

    public function delete(?string $slug): void
    {
        try {
            $this->postService->delete($slug);
            $this->dispatchBrowserEvent('post:deleted', [
                'message' => 'Post has been deleted successfully!'
            ]);
            $this->emit('$refresh');
        } catch (Throwable $e) {
            abort(404);
        }
    }

    public function render()
    {
        $posts = $this->postService->getPosts(true);
        return view('livewire.post.post-records', compact('posts'));
    }
}
