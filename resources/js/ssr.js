import { createSSRApp, h } from 'vue';
import { renderToString } from '@vue/server-renderer';
import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const appPages = import.meta.glob('./Pages/**/*.vue');
const modulePages = import.meta.glob('../../Modules/**/resources/js/Pages/**/*.vue');

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: async (name) => {
            if (name.includes('::')) {
                const [module, path] = name.split('::');
                const filePath = `../../Modules/${module}/resources/js/Pages/${path}.vue`;

                const page = modulePages[filePath];
                if (!page) {
                    throw new Error(`SSR: módulo não encontrado: ${filePath}`);
                }

                return (await page()).default;
            }

            const filePath = `./Pages/${name}.vue`;
            const page = appPages[filePath];

            if (!page) {
                throw new Error(`SSR: página padrão não encontrada: ${filePath}`);
            }

            return (await page()).default;
        },
        setup({ App, props, plugin }) {
            return createSSRApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                });
        },
    })
);