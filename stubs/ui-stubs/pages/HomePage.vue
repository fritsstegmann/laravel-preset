<template>
    <div class="container">
        <div class="bg-white shadow">
            <div class="px-4 py-2 bg-gray-100 text-gray-600">Dashboard</div>

            <div class="p-4 text-gray-800">
                You are logged in! <span v-if="user">{{ user.name }}</span>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import {Component, Vue} from "vue-property-decorator";
    import {userBloc, UserBloc} from "../blocs/user_bloc";
    import {inject} from "vue-typescript-inject";

    @Component<HomePage>({
        components: {},
        props: [],
        subscriptions() {
            return {};
        },
        data() {
            return {
                user: null,
            };
        },
        providers: [userBloc],
    })
    export default class HomePage extends Vue {

        @inject(UserBloc) private readonly userBloc!: UserBloc;

        private user?: any;

        created() {
            this.userBloc.user.subscribe((user) => {
                this.user = user;
            });
        }

        mounted() {
            this.userBloc.fetchUser();
        }
    }
</script>

<style scoped lang="scss">
</style>
