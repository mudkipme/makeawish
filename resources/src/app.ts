import { createApp, h } from 'vue';
import { App, plugin } from '@inertiajs/inertia-vue3';
import 'bootstrap';

const el = document.getElementById('app');

if (el) {
    createApp({
        render: () => h(App, {
          initialPage: JSON.parse(el.dataset.page || ''),
          resolveComponent: name => require(`./pages/${name}.vue`).default,
        }),
    }).use(plugin).mount(el);
};
