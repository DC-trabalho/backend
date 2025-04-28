import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const appPages = import.meta.glob("./Pages/**/*.vue");
const modulePages = import.meta.glob(
    "../../Modules/**/resources/js/Pages/**/*.vue"
);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        if (name.includes("::")) {
            const [module, path] = name.split("::");
            const filePath = `../../Modules/${module}/resources/js/Pages/${path}.vue`;

            const page = modulePages[filePath];
            if (!page) {
                throw new Error(`Módulo não encontrado: ${filePath}`);
            }

            return (await page()).default;
        }

        const filePath = `./Pages/${name}.vue`;
        const page = appPages[filePath];

        if (!page) {
            throw new Error(`Página padrão não encontrada: ${filePath}`);
        }

        return (await page()).default;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});