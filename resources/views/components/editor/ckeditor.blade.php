@props(['id', 'label', 'model', 'isUpdate' => false, 'updateData' => null])
@push('scripts')
<script>
    window.addEventListener('alpine:init', () => {
        Alpine.store('post', {
            updateData: "{{ $updateData }}"
        })
    })
</script>
@endpush
{{-- CKEDITOR 5 --}}
<div x-data="{
    isUpdate: '{{ $isUpdate }}',
    async initCKEditor() {

                // initialize ckeditor5
                window.ckeditor = await ClassicEditor.create(document.querySelector('#{{ $id }}'), {
                    height: 900,
                    mediaEmbed: {previewsInData: true},
                    ckfinder: {
                        uploadUrl: `{{ route('image.store') }}?type=ckeditor`
                    }
                })
        
                if (this.isUpdate) {
                    this.postBody = $store.post?.updateData
                }
                
                window.ckeditor.model.document.on('change:data', () => {
                    this.postBody = window.ckeditor.getData()
                })
        

    },
}" x-init="initCKEditor()">

    <div wire:ignore>
        <label for="{{ $id }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }}
        </label>
        <textarea x-cloak id="{{ $id }}" wire:model.lazy="{{ $model }}"></textarea>
    </div>
    <x-form.error model="{{ $model }}" />

</div>
