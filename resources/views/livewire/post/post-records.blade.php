@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('post:deleted', (e) => {
                Swal.fire('Success', e.detail.message, 'success')
            })
        })
    </script>
@endpush

<div x-data="{
    deletePost(slug) {

        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.call('delete', slug)
            }
        })

    }
}">
    <x-alert.sweetalert session="success" title="Success" />
    <x-alert.sweetalert session="error" title="Error" type="error" />

    <x-form.button class="mb-4" @click.prevent="location.href = `{{ route('post.create') }}`">
        Add Post
    </x-form.button>


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
            @forelse ($posts as $post)
                <tr @class([
                    'border-b dark:border-gray-700 dark:bg-gray-800',
                    'bg-gray-50' => $loop->iteration % 2 === 0,
                    'bg-white' => $loop->iteration % 2 !== 0,
                ])>
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
                            <x-form.button id="actionDropdownButton-{{ $loop->iteration }}"
                                data-dropdown-toggle="actionDropdown-{{ $loop->iteration }}"
                                buttonType="primary">
                                Action
                                <svg class="ml-2 h-4 w-4" aria-hidden="true" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </x-form.button>
                            <!-- Dropdown menu -->
                            <div id="actionDropdown-{{ $loop->iteration }}"
                                class="z-10 hidden w-44 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="actionDropdownButton-{{ $loop->iteration }}"
                                    wire:key="dropdown-{{ $loop->iteration }}">
                                    @include('livewire.post.partials._dropdown-link', [
                                        'route' => 'post.show',
                                        'label' => 'Detail',
                                    ])
                                    @include('livewire.post.partials._dropdown-link', [
                                        'route' => 'post.edit',
                                        'label' => 'Edit',
                                    ])

                                    <li>
                                        <a href="" @click.prevent="deletePost('{{ $post->slug }}')"
                                            class="block cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Delete
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="">
                    <td colspan="5" class="py-2 text-center text-lg font-medium text-gray-500">
                        No
                        post
                        records
                        found...</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="my-4 px-2">
        {{ $posts->links() }}
    </div>


</div>
