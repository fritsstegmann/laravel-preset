import Vue from 'vue';

import VueRx from 'vue-rx';
import router from '@app/router';
import App from '@app/App.vue';

Vue.use(VueRx);

new Vue({
    router,
    el: '#app',
    render: h => h(App),
});
