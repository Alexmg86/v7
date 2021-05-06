require('./bootstrap');

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import vClickOutside from "click-outside-vue3";

const app = createApp({})
app.component('index', require('./components/Index.vue').default)
app.use(vClickOutside)
app.mount('#app')
