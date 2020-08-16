import Vue from 'vue';
import VueRouter from 'vue-router';

import HomePage from './pages/HomePage.vue';
import LoginPage from './pages/LoginPage.vue';
import AppScaffold from "./AppScaffold.vue";

Vue.use(VueRouter);

export default new VueRouter({
    base: '',
    mode: "history",
    routes: [
        {
            path: '/',
            component: AppScaffold,
            children: [
                {
                    path: '/home',
                    component: HomePage,
                }
            ]
        },
        {
            path: '/login',
            component: LoginPage,
        }
    ],
});
