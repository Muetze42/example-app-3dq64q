import {createApp, h} from 'vue';
import {createInertiaApp, Link} from '@inertiajs/inertia-vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {InertiaProgress} from '@inertiajs/progress'
import Layout from './Components/Layout.vue'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import Pagination from './Components/Pagination.vue';
import axios from 'axios';
window.axios = axios;

createInertiaApp({
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );
        page.then((module) => {
            module.default.layout = module.default.layout || Layout;
        });
        return page;
    },
    setup({el, App, props, plugin}) {
        const VueApp = createApp({render: () => h(App, props)})

        VueApp
            .use(plugin)
            .component("Link", Link)
            .component("Pagination", Pagination)
            .component("font-awesome-icon", FontAwesomeIcon)
            .mixin({
                methods: {
                    __(key, replace = {}) {
                        var translation = this.$page.props.translations[key]
                            ? this.$page.props.translations[key]
                            : key

                        Object.keys(replace).forEach(function (key) {
                            translation = translation.replace(':' + key, replace[key])
                        });

                        return translation
                    },
                }
            })
            .mount(el)
    },
});

InertiaProgress.init({
    delay: 300,
    color: '#0ea5e9',
    includeCSS: true,
    showSpinner: true,
})
