<template>
    <VueBlocProvider :provides="blocs">
        <router-view/>
    </VueBlocProvider>
</template>

<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import VueBlocProvider from './VueBlocProvider';
import AuthBloc, {AuthEvent} from './blocs/AuthBloc';
import UserRepository from './repository/UserRepository';
import axios from 'axios';

@Component({
    components: {VueBlocProvider},
})
export default class App extends Vue {
    private blocs: Record<string, unknown> = {};

    created(): void {
        const bus = new Vue()

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
            bus,
        )

        bus.$on(AuthEvent.LOGIN, () => {
            this.$router.replace('/home')
        })

        bus.$on(AuthEvent.LOGOUT, () => {
            this.$router.replace('/login')
        })

        this.blocs = {
            'authBloc': authBloc,
        }
    }
}
</script>
