import Vue from 'vue';
import VueRouter from 'vue-router';

import HomePage from './pages/HomePage.vue';

Vue.use(VueRouter);

export default new VueRouter({
    base: '',
    routes: [
        {
            path: '',
            name: '',
            component: HomePage,
        },
    ],
});
