require('./bootstrap');

import { createApp } from 'vue/dist/vue.esm-bundler.js';

const app = createApp({})
app.component('index', require('./components/Index.vue').default)
app.mount('#app')
