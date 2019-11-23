<template>
    <div class="container m-auto">
        <div class="py-2 uppercase tracking-wider text-sm text-gray-600 rounded">Dashboard</div>
        <div class="bg-white shadow rounded">
            <div class="p-4 text-gray-800">
                <span v-if="error">{{ error }}</span>
                <span v-if="user">You are logged in! {{ user.name }}</span>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import {Component, Inject, Vue} from "vue-property-decorator";
    import {UserBloc} from "../blocs/user_bloc";

    @Component<HomePage>({
        components: {},
        props: [],
        subscriptions() {
            return {};
        },
        data() {
            return {
                user: null,
                error: null,
            };
        },
    })
    export default class HomePage extends Vue {

        @Inject('userBloc') private readonly userBloc!: UserBloc;

        private user?: any;
        private error?: string;

        created() {
            this.userBloc.user.subscribe((user) => {
                this.user = user;
                this.error = undefined;
            }, error => {
                this.error = error;
            });
        }

        mounted() {
            this.userBloc.fetchUser();
        }
    }
</script>

<style scoped lang="scss">
</style>
