{{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
<div class="py-10" x-data>
    <div class="-mt-10">
        <x-form.button @click.prevent="location.href=`{{ route('post.index') }}`" class="gap-1">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </span>
            <span>Back</span>
        </x-form.button>
    </div>
    <div>
        <div class="mx-auto w-1/2">
            <h1 class="text-center text-4xl font-bold leading-10 text-gray-800">{{ $post->title }}</h1>
            <div class="mx-auto mt-2 flex items-center justify-center gap-4">
                <small class="text-sm text-gray-500">Posted by:
                    {{ $post->author?->name }}</small>
                <time
                    class="inline-block text-sm text-gray-600">{{ $post->created_at?->diffForHumans() }}</time>
            </div>

        </div>
    </div>

    <div>
        <div class="mx-auto mt-10 h-80 w-3/4">
            <img src="{{ $post->image ?? 'https://source.unsplash.com/1200x400/?blog' }}"
                class="rounded-lg object-cover object-center shadow" lazy alt="Post Image" />
        </div>
    </div>

    <div class="text-base text-gray-600 first-letter:text-5xl first-letter:font-bold">
        <article class="mx-auto w-3/4 space-y-2">
            {!! $post->body !!}
        </article>
    </div>
</div>
