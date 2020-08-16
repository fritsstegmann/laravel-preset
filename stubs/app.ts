import Vue from 'vue';

import VueRx from 'vue-rx';
import router from './router';
import App from './App.js';

Vue.use(VueRx);

new Vue({
    router,
    el: '#app',
    render: h => h(App),
});
