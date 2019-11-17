import "./bootstrap";

import Vue from 'vue';

import VueRx from 'vue-rx';
import {AxiosPlugin} from './http';
import VueTypeScriptInject from "vue-typescript-inject";
import router from './router';
import store from './store';

import App from './App.vue';

Vue.use(VueRx);

Vue.use(AxiosPlugin);

Vue.use(VueTypeScriptInject);

new Vue({
    router,
    store,
    el: '#app',
    render: h => h(App)
});
