<template>
    <div>
        <Header></Header>
        <router-view></router-view>
    </div>
</template>

<script lang="ts">
import {Component, Inject, Vue} from "vue-property-decorator";
import Header from "./components/Header.vue";
import AuthBloc from "./blocs/AuthBloc";

@Component({
    components: {Header}
})
export default class AppScaffold extends Vue {

    @Inject('authBloc')
    private authBloc!: AuthBloc

    created() {
        this.authBloc.getMe()
    }
}
</script>
