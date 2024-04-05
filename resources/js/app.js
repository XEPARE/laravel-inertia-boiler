import './bootstrap';

import {createApp, h} from 'vue';
import {createInertiaApp, Link} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/index.js';

// Mixins
import base from './base';

// Plugins
import {i18nVue} from "laravel-vue-i18n";

// Misc
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

// Initialize Inertia App
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            /* Plugins */
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(i18nVue, {
                resolve: async lang => {
                    const languageFiles = import.meta.glob('../../lang/*.json');
                    return await languageFiles[`../../lang/${lang}.json`]();
                }
            })
            /* Mixins */
            .mixin(base)
            /* Components */
            .component('inertia-link', Link)
            /* Mountpoint */
            .mount(el);
    },
    //progress: false, // Disable progress bar
    progress: {
        color: '#4B5563',
    },
});
