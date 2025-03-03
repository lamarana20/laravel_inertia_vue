import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindConfig from './tailwind.config';


export default defineConfig({
    
    plugins: [
        vue(),
        tailwindConfig,
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],

            refresh: true,
        }),
    ],
});
