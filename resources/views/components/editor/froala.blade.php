{{-- TINYMCE 6 --}}
@props(['id', 'label', 'model', 'isUpdate' => false, 'updateData' => null])

<div x-data="{
    isUpdate: '{{ $isUpdate }}',
    froalaEditor: null,
    async froala() {
        const options = {
            heightMin: 11.25 * 16,
            imageUploadURL: `{{ route('image.store') }}`,
            imageUploadParams: {
                froala: true
            },
            imageUploadParam: 'post_attachment',
            imageUploadMethod: 'POST',
        }

        this.froalaEditor = new FroalaEditor('#{{ $id }}', options, () => {
            {{-- keep watch on postBody state and update the editor whenever the state is changed --}}
            $watch('postBody', () => {
                if ([0, 1].includes(editor)) {
                    this.froalaEditor.html.set(this.postBody)
                }
            })

            this.froalaEditor.events.on('keyup', () => {
                this.postBody = this.froalaEditor.html.get()
            })

            this.froalaEditor.events.on('contentChanged', () => {
                this.postBody = this.froalaEditor.html.get()
            })

            {{-- handle image ulpoad error --}}
            this.froalaEditor.events.on('image.error', (err, res) => {
                let msg = '';
                for (message of JSON.parse(res)?.post_attachment) {
                    msg += message + '\n'
                }

                Swal.fire('Error!', msg, 'error')
            })

            {{-- handle image remove --}}
            this.froalaEditor.events.on('image.removed', ($img) => {
                let srcs = [];
                for (let i = 0; i < $img.length; i++) {
                    srcs.push($img[i]?.currentSrc)
                }

                {{-- request to server to delete the image --}}
                const res = axios.post(`{{ route('image.destroy') }}`, {
                    srcs,
                }).catch((err) => {
                    {{-- error message --}}
                    if (err.response?.data?.status === false) {
                        let msgs = ''
                        for (message of err.response?.data?.messages) {
                            msgs += message + '\n'
                        }
                        Swal.fire('Error!', msgs, 'error')
                        return;
                    }
                })

            })
        });

    }
}" x-init="await froala();"
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
