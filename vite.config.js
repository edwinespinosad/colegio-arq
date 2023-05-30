import { defineConfig } from 'vite';
import vue from "@vitejs/plugin-vue"
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/less/colors.less',
                // LP
                'resources/less/lp.less','resources/js/Lp/app.js',
                // CLIENT
                'resources/css/app.css', 'resources/js/Client/app.js',
                // TEACHER
                'resources/less/teacher.less','resources/js/Teacher/app.js',
                //ADMIN LOGIN
                'resources/less/login.less','resources/js/Admin/auth/app.js',
                //ADMIN CONTENT
                'resources/less/admin.less','resources/js/Admin/app.js',
            ],
            refresh: true,
        }),
        vue()
    ],
    css: {
        preprocessorOptions: {
            less: {
                math: 'always',
                relativeUrls: true,
                javascriptEnabled: true
            }
        }
    }
});
