<template>
    <nav class="bg-white h-16">
        <div class="flex container m-auto">
            <a class="mt-5 text-gray-700 flex-grow" href="/home">
                {{ appName }}
            </a>
            <!-- Right Side Of Navbar -->
            <ul class="mt-5 ml-auto">
                <!-- Authentication Links -->
                <li class="flex">
                    <div>
                        {{ userName }}
                    </div>

                    <div class="ml-4">
                        <a class="py-2 px-4 rounded shadow text-gray-300 bg-gray-700" href="/logout" @click.prevent="logout">
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script lang="ts">
    import {Component, Vue} from "vue-property-decorator";

    @Component<Header>({
        components: {},
        subscriptions() {
            return {}
        },
        props: [],
        data() {
            return {
                'appName': null,
                'userName': null,
                'isAuth': null,
            };
        }
    })
    export default class Header extends Vue {
        private appName?: string;
        private userName?: string;
        private isAuth?: boolean;

        mounted() {
            this.appName = this.$laravel.appName;
            this.userName = this.$laravel.userName;
            this.isAuth = this.$laravel.isAuth;
        }

        logout() {
            this.$http.post('/logout').then(() => {
                window.location.href = "/";
            });
        }
    }
</script>

<style scoped lang="scss">
</style>
