import "./bootstrap";

import Vue from 'vue';

import VueRx from 'vue-rx';
import {AxiosPlugin} from './http';
import router from './router';
import store from './store';

import App from './App.vue';

Vue.use(VueRx);

Vue.use(AxiosPlugin, {
    timeout: 5000,
});

new Vue({
    router,
    store,
    el: '#app',
    render: h => h(App),
});
