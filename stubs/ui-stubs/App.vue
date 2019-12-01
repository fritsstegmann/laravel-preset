<template>
    <div>
        <VueBlocProvider :provides="blocs">
            <div>
                <Header></Header>
                <main class="mt-4 container m-auto">
                    <router-view/>
                </main>
            </div>
        </VueBlocProvider>
    </div>
</template>

<script lang="ts">
    import {Component, Vue} from "vue-property-decorator";
    import VueBlocProvider from "./VueBlocProvider";
    import {UserBloc} from "./blocs/user_bloc";
    import Header from "./components/Header.vue";

    @Component<App>({
        components: {VueBlocProvider, Header},
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
