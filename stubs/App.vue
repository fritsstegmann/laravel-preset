<template>
    <VueBlocProvider :provides="blocs">
        <router-view/>
    </VueBlocProvider>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import VueBlocProvider from "./VueBlocProvider";
import AuthBloc from "./blocs/AuthBloc";
import UserRepository from "./repository/UserRepository";
import axios from 'axios';

@Component({
    components: {VueBlocProvider},
})
export default class App extends Vue {
    private blocs: object = {};

    created() {
        const axiosInstance = axios.create({
            withCredentials: true,
            headers: {
                common: {
                    'Content-Type': 'application/json',
                    'X-Request-With': 'XMlHtppRequest'
                }
            }
        })

        const authBloc = new AuthBloc(new UserRepository(axiosInstance))
        authBloc.getMe()

        this.blocs = {
            'authBloc': authBloc
        }
    }
}
</script>
