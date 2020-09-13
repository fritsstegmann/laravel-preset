import Vue from 'vue'

import VueRx from 'vue-rx'
import router from '@app/router'
import App from '@app/App.vue'

import '../scss/app.scss'
import axios from 'axios'
import AuthBloc from '@app/blocs/AuthBloc'
import UserRepository from '@app/repository/UserRepository'

Vue.use(VueRx)


const axiosInstance = axios.create({
    withCredentials: true,
    headers: {
        common: {
            'Content-Type': 'application/json',
            'X-Request-With': 'XMlHttpRequest',
        },
    },
})

const authBloc = new AuthBloc(
    new UserRepository(axiosInstance),
)

new Vue({
    router,
    el: '#app',
    render: h => h(App),
    provide: {
        'authBloc': authBloc,
    },
});
