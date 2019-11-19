<template>
    <div>
        <VueBlocProvider :provides="blocs">
            <router-view/>
        </VueBlocProvider>
    </div>
</template>

<script lang="ts">
    import {Component, Vue} from "vue-property-decorator";
    import VueBlocProvider from "./VueBlocProvider";
    import {UserBloc} from "./blocs/user_bloc";

    @Component<App>({
        components: {VueBlocProvider},
        props: [],
        subscriptions() {
            return {};
        },
        data() {
            return {
                blocs: {}
            };
        }
    })
    export default class App extends Vue {
        private blocs: object = {};

        created() {
            this.blocs = {
                'userBloc': new UserBloc(this),
            }
        }
    }
</script>

<style scoped lang="scss">
</style>
