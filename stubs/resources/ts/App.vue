<template>
    <router-view/>
</template>

<script lang="ts">
import {Component, Inject, Vue} from 'vue-property-decorator'
import AuthBloc, {AuthEvent} from '@app/blocs/AuthBloc'

@Component
export default class App extends Vue {

    @Inject('authBloc')
    private authBloc!: AuthBloc

    created(): void {
        this.authBloc.event.subscribe((event) => {
            if (event === AuthEvent.LOGIN) {
                this.$router.push({
                    name: 'home',
                })
            } else if (event === AuthEvent.LOGOUT) {
                this.$router.push({
                    name: 'login',
                })
            }
        })
    }
}
</script>
