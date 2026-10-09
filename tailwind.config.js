import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
            },
            colors: {
                ember: '#ff5406',
                verdant: '#00b33f',
                signal: '#ff3400',
                skybrand: '#00a9dd',
                mist: '#72a2c5',
                sunset: '#ff6d00',
                amberdeep: '#945300',
                alert: '#ff001e',
                plum: '#bd4be5',
                iris: '#5856de',
                electric: '#0099f9',
                graphite: '#2f2f2f',
                charcoal: '#000000',
                fog: '#f5f5f5',
                paper: '#ffffff',
            },
            borderRadius: {
                pill: '26px',
            },
            maxWidth: {
                page: '1200px',
            },
        },
    },

    plugins: [forms],
};
