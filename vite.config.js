import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/passkeys.js',
                'resources/js/rich-text.js',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    optimizeDeps: {
        include: [
            '@tiptap/core',
            '@tiptap/starter-kit',
            '@tiptap/extension-table',
            '@tiptap/extension-link',
            '@tiptap/extension-placeholder',
            '@tiptap/extension-underline',
            '@tiptap/extension-text-align',
        ],
    },
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
