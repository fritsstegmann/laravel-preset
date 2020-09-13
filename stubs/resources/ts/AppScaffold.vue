<template>
    <div>
        <Header></Header>
        <router-view></router-view>
    </div>
</template>

<script lang="ts">
import {Component, Inject, Vue} from 'vue-property-decorator'
import Header from '@app/components/Header.vue'
import AuthBloc from '@app/blocs/AuthBloc'

@Component({
    components: {Header},
})
export default class AppScaffold extends Vue {

    @Inject('authBloc')
    private authBloc!: AuthBloc

    created(): void {
        this.authBloc.getMe()
    }
}
</script>
