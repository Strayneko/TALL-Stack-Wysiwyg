<button @click.prevent="changeEditor({{ $editor }})" type="button" @class([
    'border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:text-blue-700 focus:ring-2 focus:ring-blue-700 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:hover:text-white dark:focus:text-white dark:focus:ring-blue-500',
    'rounded-l-lg border' => $editor === 0,
    'border-t border-b' => $editor === 1,
    'rounded-r-md border' => $editor === 2,
])
    x-bind:class="editor == {{ $editor }} ? '!bg-primary text-white focus:text-white' : ''">
    {{ $label }}
</button>
