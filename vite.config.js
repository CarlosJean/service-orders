import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/azia.min.css',
                'resources/css/azia.css',
                'resources/sass/app.scss',
                'resources/css/quotes.css',
                'resources/js/app.js',
                'resources/js/azia.js',
                'resources/js/employeesList.js',
                'resources/js/serviceOrders.js',
                'resources/js/assignTechnician.js',
                'resources/js/quotes.js',
                'resources/js/materialsManagement.js',
            ],
            refresh: true,
        }),
    ],
});