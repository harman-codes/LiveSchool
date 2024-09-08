import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    //comment server if you are not using ip address host : Harman
    // server: {
    //     host: '127.0.0.1',
    // },
});
