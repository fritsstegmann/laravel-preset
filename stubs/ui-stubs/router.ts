import Vue from 'vue';
import VueRouter from 'vue-router';

import HomePage from './pages/HomePage.vue';
import LoginPage from './pages/LoginPage.vue';

Vue.use(VueRouter);

export default new VueRouter({
    base: '',
    mode: "history",
    routes: [
        {
            path: '/home',
            component: HomePage,
        },
        {
            path: '/login',
            component: LoginPage,
        }
    ],
});
