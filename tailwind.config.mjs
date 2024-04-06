const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/**/*.vue',
        './resources/js/**/**/**/*.vue',
        './resources/js/**/**/**/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                primary: {
                    DEFAULT: '#3B82F6',
                    50: '#EBF2FE',
                    100: '#D7E6FD',
                    200: '#B0CDFB',
                    300: '#89B4FA',
                    400: '#629BF8',
                    500: '#3B82F6',
                    600: '#0B61EE',
                    700: '#084BB8',
                    800: '#063583',
                    900: '#041F4D',
                    950: '#021532'
                },
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/aspect-ratio')
    ],
};
