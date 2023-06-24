<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;
use App\Services\PostService;

class CreatePost extends Component
{

    public Post $post;
    public $editor = 0;

    private PostService $postService;

    protected $rules = [
        'post.title' => 'required',
        'post.body' => 'required',
    ];

    public function boot(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function mount(): void
    {
        $this->post = new Post();
    }

    public function store()
    {
        $this->validate();
        $this->postService->store($this->post);

        // reset input
        $this->post = new Post();

        $this->dispatchBrowserEvent('post:submitted');

        return redirect()->route('post.index')->with('success', 'New Post has been added.');
    }

    public function render()
    {
        return view('livewire.post.create-post');
    }
}
