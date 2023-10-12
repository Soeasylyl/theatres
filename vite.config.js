import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/admin/app.scss',
                'resources/sass/public/app.scss',
                'resources/js/admin/app.js',
                'resources/js/public/app.js',
            ],
            refresh: true,
        }),
    ],
});
