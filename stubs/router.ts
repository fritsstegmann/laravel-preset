import Vue from 'vue';
import VueRouter from 'vue-router';

import HomePage from './pages/HomePage.js';
import LoginPage from './pages/LoginPage.js';

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
