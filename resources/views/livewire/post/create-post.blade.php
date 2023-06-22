<div id="addPost" x-data="{
    postBody: null,
    async submit() {
        await $wire.set('post.body', this.postBody)
        $wire.call('store')
    },
    async initCKEditor() {
        // initialize ckeditor5
        window.editor = await ClassicEditor.create(document.querySelector('#postBody'), {
            height: 900
        })

        window.editor.model.document.on('change:data', () => {
            this.postBody = window.editor.getData()
        })
    }
}" x-init="await initCKEditor()"
    @post:submitted.window="window.editor.setData('')">
    <h1 class="text-3xl font-bold dark:text-gray-300">Add Post</h1>

    <form action="" class="mt-4 space-y-4">
        <div class="w-1/2">
            <label for="first_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Post
                Title</label>
            <input type="text" id="first_name"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                placeholder="John" wire:model.lazy="post.title" required>

            <x-form.error model="post.title" />
        </div>

        {{-- ckeditor --}}
        <div class="w-1/2" wire:ignore>
            <label for="postBody" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Post
                Body</label>
            <textarea x-cloak id="postBody" wire:model.lazy="post.body"></textarea>
        </div>
        <x-form.error model="post.body" />

        <div class="w-1/3">
            <x-form.button type="danger" @click.prevent="location.href=`{{ route('post.index') }}`">
                Back
            </x-form.button>
            <x-form.button @click.prevent="submit()">
                Post
            </x-form.button>
        </div>
    </form>
</div>
