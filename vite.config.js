import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'node:path';
import path from 'path';
import { defineConfig } from 'vite';
import collectModuleAssetsPaths from './vite-module-loader.js';

const modulesPath = path.resolve(__dirname, 'Modules');
const modules = fs.readdirSync(modulesPath).filter((name) => {
    return fs.existsSync(path.join(modulesPath, name, 'resources/js'));
});

const dynamicAliases = modules.reduce((aliases, moduleName) => {
    aliases[`@${moduleName}`] = path.resolve(modulesPath, moduleName, 'resources/js');
    return aliases;
}, {});

async function getConfig() {
    const paths = ['resources/css/app.css', 'resources/js/app.js'];
    const allPaths = await collectModuleAssetsPaths(paths, 'Modules');

    return defineConfig({
        plugins: [
            laravel({
                input: allPaths,
                ssr: 'resources/js/ssr.js',
                refresh: true,
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
        resolve: {
            alias: {
                '@': path.resolve(__dirname, './resources/js'),
                'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
                '@modules': path.resolve(__dirname, 'Modules'),
                ...dynamicAliases,
            },
        },
    });
}
export default getConfig();