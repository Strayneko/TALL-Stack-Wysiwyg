<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;
use App\Services\PostService;
use Throwable;

class EditPost extends Component
{
    public ?Post $post;
    public string $slug;

    protected $rules = [
        'post.title' => 'required|max:255',
        'post.body'  => 'required'
    ];

    private PostService $postService;

    public function boot(PostService $postService): void
    {
        $this->postService = $postService;
    }

    public function mount(): void
    {
        try {
            $this->post = $this->postService->findOne($this->slug);
        } catch (Throwable $e) {
            abort(404);
        }
    }

    public function update()
    {
        $this->validate();
        $this->postService->update($this->post);

        // reset field
        $this->post = new Post();
        $this->dispatchBrowserEvent('post:submitted');

        return redirect()->route('post.index')->with('success', 'Post has been updated successfully.');
    }

    public function render()
    {
        return view('livewire.post.edit-post');
    }
}
