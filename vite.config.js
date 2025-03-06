import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'], // Añade múltiples puntos de entrada si es necesario
            refresh: true, // Habilita la recarga automática
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '0.0.0.0', // Permite acceso desde fuera del contenedor
        port: 5173,      // Puerto predeterminado de Vite
        hmr: {
            host: 'localhost', // Host para HMR
        },
    },
});