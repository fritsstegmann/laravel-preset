import "./bootstrap";

import Vue from 'vue';
import VueRx from 'vue-rx';

import App from './App.vue';

Vue.use(VueRx);

new Vue({
    el: '#app',
    render: h => h(App)
});
