import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import react from '@vitejs/plugin-react';

export default defineConfig({
    build: {
        target: 'esnext' //browsers can handle the latest ES features
    },
    plugins: [
        vue(),
        react(),
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        })
    ],
});
