import './bootstrap'

import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

window.Alpine = Alpine
window.ClassicEditor = ClassicEditor

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
