@props(['id', 'label', 'model', 'isUpdate' => false, 'updateData' => null])

{{-- CKEDITOR 5 --}}
<div x-data="{
    isUpdate: '{{ $isUpdate }}',
    syncData() {
        $watch('postBody', () => {
            if ([2, 1].includes(editor)) {
                window.ckeditor.setData(postBody)
            }
        })
    },
    async initCKEditor() {
        // initialize ckeditor5
        window.ckeditor = await ClassicEditor.create(document.querySelector('#{{ $id }}'), {
            height: 900,
        })

        if (this.isUpdate) {
            this.postBody = `{{ $updateData }}`
        }
        window.ckeditor.model.document.on('change:data', () => {
            this.postBody = window.ckeditor.getData()
        })
        this.syncData()

    }
}" x-init="await initCKEditor();"
    {{ $attributes->merge([
        'class' => 'w-1/2',
    ]) }}>

    <div wire:ignore>
        <label for="{{ $id }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }}
        </label>
        <textarea x-cloak id="{{ $id }}" wire:model.lazy="{{ $model }}"></textarea>
    </div>
    <x-form.error model="{{ $model }}" />

</div>
