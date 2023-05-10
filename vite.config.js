import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/azia.min.css',
                'resources/css/azia.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/azia.js',
                'resources/js/employeesList.js'
            ],
            refresh: true,
        }),
    ],
});
