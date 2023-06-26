<div id="addPost" x-data="{
    postBody: null,
    editor: 0,
    postTitle: '',
    async submit() {
        await $wire.set('post.body', this.postBody)
        $wire.call('store')
    },
    async edit() {
        await $wire.set('post.body', this.postBody)
        $wire.call('update')
    }
}" x-init="$watch('postTitle', () => {
    if (postTitle.length > 255) {
        postTitle = postTitle.slice(0, 255)
    }
})">
    <h1 class="text-3xl font-bold dark:text-gray-300">{{ $type === 'store' ? 'Add' : 'Edit' }} Post</h1>
    @include('livewire.post.partials._editor-selector')

    <form action="" class="mt-4 space-y-4">
        <div class="w-1/2">
            <label for="first_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Post
                Title</label>
            <input type="text" id="first_name" x-model="postTitle"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                placeholder="John" wire:model.lazy="post.title" required>
            <span class="float-right mt-1 text-sm text-gray-500"><span
                    x-text="postTitle.length"></span>/255</span>
            <x-form.error model="post.title" />
        </div>

        <div x-show="editor == 0">
            {{-- ckeditor --}}
            <x-editor.ckeditor model="post.body" id="postBody" label="Post Body" />
        </div>
        <div x-show="editor == 1">
            {{-- tinymce --}}
            <x-editor.tinymce model="post.body" id="postBody1" label="Post Body" />
        </div>
        <div x-show="editor == 2">
            {{-- froala --}}
            <x-editor.froala model="post.body" id="postBody2" label="Post Body" />
        </div>
        <div class="w-1/3">
            <x-form.button buttonType="danger" @click.prevent="location.href=`{{ route('post.index') }}`">
                Back
            </x-form.button>
            <x-form.button @click.prevent="{{ $type === 'store' ? 'submit()' : 'edit()' }}">
                {{ $type === 'store' ? 'Post' : 'Save' }}
            </x-form.button>
        </div>
    </form>
</div>
