<div id="addPost" x-data="{
    postBody: null,
    editor: 0,
    titleRef: null,
    async submit() {
        await $wire.set('post.body', this.postBody)
        $wire.call('store')
    },
    async edit() {
        await $wire.set('post.body', this.postBody)
        $wire.call('update')
    }
}">
    <h1 class="text-3xl font-bold dark:text-gray-300">{{ $type === 'store' ? 'Add' : 'Edit' }} Post</h1>
    @include('livewire.post.partials._editor-selector')

    <form action="" class="mt-4 space-y-4">
        <div class="w-1/2">
            <label for="postTitle" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Post
                Title</label>
            <input type="text" id="postTitle"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                placeholder="First Post" wire:model.lazy="post.title" required>
            <x-form.error model="post.title" />
        </div>

        <div x-show="editor == 0">
            {{-- ckeditor --}}
            @if ($type === 'edit')
                <x-editor.ckeditor model="post.body" id="postBody" label="Post Body" :isUpdate="true"
                    :updateData="$post->body" />
            @else
                <x-editor.ckeditor model="post.body" id="postBody" label="Post Body" />
            @endif
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
            <x-form.button wire:loading.attr="disabled" wire:target="store,update"
                @click.prevent="{{ $type === 'store' ? 'submit()' : 'edit()' }}">
                {{ $type === 'store' ? 'Post' : 'Save' }}
            </x-form.button>
        </div>
    </form>
</div>
