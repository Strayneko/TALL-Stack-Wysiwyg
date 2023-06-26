<div x-data>
    <div class="my-10">
        <h1 class="text-center text-3xl font-bold text-gray-600">
            All Post
        </h1>
    </div>
    {{-- In work, do what you enjoy. --}}
    <div class="flex flex-wrap justify-center gap-4 gap-y-10">
        @foreach ($posts as $post)
            @php($url = route('post.show', ['slug' => $post->slug, 'from' => 'dashboard']))
            <div class="group w-[30%]">
                <div
                    class="max-w-sm rounded-lg border border-gray-200 bg-white shadow transition ease-in-out group-hover:-translate-y-1 group-hover:shadow-lg dark:border-gray-700 dark:bg-gray-800">
                    <a href="{{ $url }}">
                        <img class="rounded-t-lg" lazy
                            src="{{ $post->image ?? 'https://source.unsplash.com/1200x400/?blog,' . $post->id }}"
                            alt="" />
                    </a>
                    <div class="p-5">
                        <a href="{{ $url }}">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $post->title }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            {{ $post->getPostExcerpt() }}</p>

                        <x-form.button @click.prevent="location.href=`{{ $url }}`">
                            Read more
                            <svg aria-hidden="true"
                                class="ml-2 -mr-1 h-4 w-4 transition ease-in-out group-hover:translate-x-1"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </x-form.button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    @if ($take <= count($posts))
        <div class="mt-5 flex justify-center">
            <div class="mx-auto">
                <div class="text-center">
                    <span wire:loading wire:target='loadMore'>Loading...</span>
                </div>
                <div>
                    <x-form.button wire:click="loadMore" wire:loading.remove wire:target='loadMore'>
                        Load More
                    </x-form.button>
                </div>
            </div>
        </div>
    @endif

</div>
