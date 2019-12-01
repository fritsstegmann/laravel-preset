import Vue from 'vue';

import VueRx from 'vue-rx';
import {AxiosPlugin} from './http';
import {LaravelPlugin} from './laravel';
import router from './router';
import store from './store';
import App from './App.vue';

Vue.use(VueRx);
Vue.use(LaravelPlugin);
Vue.use(AxiosPlugin, {
    timeout: 5000,
});

new Vue({
    router,
    store,
    el: '#app',
    render: h => h(App),
});
