<div class="my-5">
    <h3 class="mb-1 font-semibold">Select Text Editor</h3>
    <div class="inline-flex rounded-md shadow-sm" role="group">
        @include('livewire.post.partials._selector-button', [
            'editor' => 0,
            'label' => 'CKEditor',
        ])
        @include('livewire.post.partials._selector-button', [
            'editor' => 1,
            'label' => 'TinyMCE',
        ])
        @include('livewire.post.partials._selector-button', [
            'editor' => 2,
            'label' => 'Froala',
        ])
    </div>
</div>
