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
            html2pdf:window.html2pdf,
            toolbarButtons: {

                'moreText': {
              
                  'buttons': ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting']
              
                },
              
                'moreParagraph': {
              
                  'buttons': ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote']
              
                },
              
                'moreRich': {
              
                  'buttons': ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertHR']
              
                },
              
                'moreMisc': {
              
                  'buttons': ['undo', 'redo', 'fullscreen', 'print', 'spellChecker', 'selectAll', 'html', 'help'],
              
                  'align': 'right',
              
                  'buttonsVisible': 2
              
                }
              
              },
        }

        this.froalaEditor = new FroalaEditor('#{{ $id }}', options, () => {


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
                        {{-- Swal.fire('Error!', msgs, 'error') --}}
                        return;
                    }
                })

            })
        });

    }
}" x-init="await froala();">
    <div wire:ignore>
        <label for="{{ $id }}" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }}
        </label>
        <textarea x-cloak id="{{ $id }}" wire:model.lazy="{{ $model }}"></textarea>
    </div>
    <x-form.error model="{{ $model }}" />

</div>
