import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/inventory.css', 'resources/css/dashboard.css','resources/css/notification.css','resources/css/salesreport.css','resources/js/inventory.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
