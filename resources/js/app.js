require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

// Plugins
import { i18nVue } from 'laravel-vue-i18n'

// Mixins
import * as base from './base';

// Misc
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            /* Plugins */
            .use(plugin)
            .use(i18nVue)
            /* Mixins */
            .mixin({ methods: { route } })
            .mixin(base)
            /* Components */
            .component('inertia-link', Link)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
