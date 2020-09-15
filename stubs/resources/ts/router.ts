import Vue from 'vue';
import VueRouter from 'vue-router';

import HomePage from '@app/pages/HomePage.vue';
import LoginPage from '@app/pages/LoginPage.vue';
import AppScaffold from '@app/AppScaffold.vue';

Vue.use(VueRouter);

export default new VueRouter({
    base: '',
    mode: 'history',
    routes: [
        {
            path: '/',
            component: AppScaffold,
            children: [
                {
                    path: '/home',
                    name: 'home',
                    component: HomePage,
                },
            ],
        },
        {
            path: '/login',
            name: 'login',
            component: LoginPage,
        },
    ],
});
