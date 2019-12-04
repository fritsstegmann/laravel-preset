<template>
    <nav class="bg-white h-16">
        <div class="flex container m-auto justify-between">
            <a class="ml-2 sm:ml-0 mt-6 text-gray-700 text-lg leading-none tracking-wide focus:shadow-outline outline-none"
               href="/home">
                {{ appName }}
            </a>
            <!-- Right Side Of Navbar -->
            <ul class="mt-3 ml-auto">
                <!-- Authentication Links -->
                <li class="flex relative">
                    <button @click="displayDropdown = !displayDropdown"
                            class="mr-2 sm:mr-0 relative z-10 block focus:shadow-outline focus:outline-none outline-none h-10 w-10 rounded-full shadow-inner overflow-hidden border-2">
                        <GravatarImg :email="$laravel.userEmail"></GravatarImg>
                    </button>
                    <button @click="displayDropdown = false" v-if="displayDropdown"
                            class="fixed w-full h-full inset-0 bg-black opacity-25 cursor-default"/>
                    <div v-if="displayDropdown"
                         class="mr-2 sm:mr-0 absolute right-0 mt-12 w-48 bg-white py-2 block rounded-lg shadow-lg">
                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-700 hover:text-white" href="#">
                            Profile Settings
                        </a>
                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-700 hover:text-white" href="#"
                           @click.prevent="logout">
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
    import GravatarImg from "./GravatarImg.vue";

    @Component<Header>({
        components: {GravatarImg},
        subscriptions() {
            return {}
        },
        props: [],
        data() {
            return {
                'appName': null,
                'userName': null,
                'isAuth': null,
                'displayDropdown': false,
            };
        }
    })
    export default class Header extends Vue {
        private appName?: string;
        private userName?: string;
        private isAuth?: boolean;
        private displayDropdown?: boolean = false;

        created() {
            const handleEscape = (e: KeyboardEvent) => {
                if (e.key === 'Esc' || e.key === 'Escape') {
                    this.displayDropdown = false;
                }
            };

            document.addEventListener('keydown', handleEscape);

            this.$once('hook:beforeDestroy', () => {
                document.removeEventListener('keydown', handleEscape);
            });
        }

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
