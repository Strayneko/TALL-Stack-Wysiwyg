import './bootstrap'
import 'flowbite'

import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import Swal from 'sweetalert2'
import CKEditorCustomUploadAdapter from './CKEditorCustomUploadAdapter'

window.Alpine = Alpine
window.ClassicEditor = ClassicEditor
window.Swal = Swal

Alpine.plugin(focus)

Alpine.start()

// debouncing input
const debounce = (callback, delay = 1000) => {
    let timeout
    return (...args) => {
        clearTimeout(timeout)
        timeout = setTimeout(() => {
            callback(...args)
        }, delay)
    }
}

window.debounce = debounce
