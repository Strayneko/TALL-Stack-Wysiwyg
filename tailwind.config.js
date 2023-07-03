import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    options: {
        safelist: [
            'sm:w-full',
            'sm:max-w-md',
            'md:max-w-xl',
            'lg:max-w-3xl',
            'xl:max-w-5xl',
            '2xl:max-w-6xl',
        ],
    },

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#4299E1',
            },
        },
    },

    plugins: [forms, typography, require('flowbite/plugin')],
}
