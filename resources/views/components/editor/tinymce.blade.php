{{-- TINYMCE 6 --}}
@props(['id', 'label', 'model', 'isUpdate' => false, 'updateData' => null])
@push('scripts')
<script>
    window.addEventListener('alpine:init', () => {
        window.uploadHandler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('post_attachment', blobInfo.blob(), blobInfo.filename());
            
            // Use Axios to perform the file upload
            axios.post(`{{ route('image.store') }}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
                })
                .then((res) => {
                    // Handle successful upload
                    resolve(res.data.link);
                })
                .catch((err) => {
                    // Handle upload error
                    reject('Error uploading file: ' + err.message);
                });
            })
        })
    </script>
@endpush

<div x-data="{
    isUpdate: '{{ $isUpdate }}',
    tinymceEditor: null,
    syncData() {
        $watch('postBody', () => {
            if ([0, 2].includes(editor)) {
                this.tinymceEditor.setContent(postBody)
            }
        })
    },
    async initTinyMce() {
        imageUploadHandler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const formData = new FormData();
            formData.append('post_attachment', blobInfo.blob(), blobInfo.filename());
            
            // Use Axios to perform the file upload
            axios.post(`{{ route('image.store') }}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
                })
                .then((res) => {
                    // Handle successful upload
                    resolve(res.data.link);
                })
                .catch((err) => {
                    // Handle upload error
                    reject('Error uploading file: ' + err.message);
                });
            })

        tinymce.remove()
        await tinymce.init({
            selector: 'textarea#{{ $id }}',
            plugins: 'image',
            toolbar: 'image | undo redo | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
            images_upload_handler: imageUploadHandler,
            setup: (editor) => {
                editor.on('init', (e) => {
                    this.tinymceEditor = editor
                    window.coba = editor
                })
                editor.on('keyup', (e) => {
                    this.postBody = editor.getContent()
                });
                editor.on('change', (e) => {
                    this.postBody = editor.getContent()
                });
            }
        });
       }

    
}" x-init="await initTinyMce();">

    <div wire:ignore>
        <label for="{{ $id }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }}
        </label>
        <textarea x-cloak id="{{ $id }}" wire:model.lazy="{{ $model }}"></textarea>
    </div>
    <x-form.error model="{{ $model }}" />

</div>
