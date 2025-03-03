import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp,Head,Link } from '@inertiajs/vue3'
import '../css/app.css'
import layout from './layouts/layout.vue' 
import { ZiggyVue } from 'ziggy-js';



createInertiaApp({
  title:(title) => `  My App ${title}`,
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page= pages[`./Pages/${name}.vue`];
    page.default.layout = page.default.layout || layout;
    return page;

  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .component('layout',layout)
      .component('Head',Head)
      .component('Link', Link)
      .mount(el)
  },
  progress: {
   
    // The color of the progress bar...
    color: 'white',

    // Whether to include the default NProgress styles...
    includeCSS: true,

    // Whether the NProgress spinner will be shown...
    showSpinner: true,
    
  },
})
