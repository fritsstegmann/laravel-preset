import "./bootstrap";

import Vue from 'vue';

import VueRx from 'vue-rx';
Vue.use(VueRx);

import {AxiosPlugin} from './http';
Vue.use(AxiosPlugin);

import router from './router';
import store from './store';

import App from './App.vue';

new Vue({
    router,
    store,
    el: '#app',
    render: h => h(App)
});
