<div x-data>
    <x-form.button class="mb-4" @click.prevent="location.href = `{{ route('post.create') }}`">
        Add Post
    </x-form.button>
    <div class="relative overflow-hidden overflow-x-auto rounded-lg shadow">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Author
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Body
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
                        <th scope="row"
                            class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ ($posts->currentpage() - 1) * $posts->perpage() + $loop->index + 1 }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $post->author->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $post->title ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $post->getPostExcerpt() }}
                        </td>
                        <td class="w-1/6 px-6 py-4">
                            <div class="flex items-center gap-2">
                                <x-form.button type="info">
                                    Detail
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="my-4 px-2">
            {{ $posts->links() }}
        </div>
    </div>

</div>
