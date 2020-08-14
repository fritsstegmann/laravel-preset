<template>
    <nav class="bg-white h-16">
        <div class="flex container m-auto justify-between">
            <a class="ml-2 sm:ml-0 mt-6 text-gray-700 text-lg leading-none tracking-wide focus:shadow-outline outline-none"
               href="/home">
                Laravel
            </a>
            <!-- Right Side Of Navbar -->
            <ul class="mt-3 ml-auto">
                <!-- Authentication Links -->
                <li class="flex relative" v-if="me">
                    <button @click="displayDropdown = !displayDropdown"
                            class="mr-2 sm:mr-0 relative z-10 block focus:shadow-outline focus:outline-none outline-none h-10 w-10 rounded-full shadow-inner overflow-hidden border-2">
                        <GravatarImg
                            :email="me.email"
                        />
                    </button>
                    <button @click="displayDropdown = false" v-if="displayDropdown"
                            class="fixed w-full h-full inset-0 bg-black opacity-25 cursor-default"/>
                    <div v-if="displayDropdown"
                         class="mr-2 sm:mr-0 absolute right-0 mt-12 w-48 bg-white py-2 block rounded-lg shadow-lg">
                        <router-link to="/profile-settings"
                                     class="block px-4 py-2 text-gray-800 hover:bg-gray-700 hover:text-white">
                            Profile Settings
                        </router-link>
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
import {Component, Inject, Vue} from "vue-property-decorator";
import AuthBloc from "../blocs/AuthBloc";
import GravatarImg from "../components/GravatarImg.vue";

@Component({
    components: {GravatarImg}
})
export default class Header extends Vue {
    private displayDropdown?: boolean = false;

    @Inject('authBloc')
    private authBloc!: AuthBloc

    private me: any = null

    created() {
        this.$subscribeTo(this.authBloc.me, (me: any) => {
            this.me = me
        }, (err: any) => {
            console.error(err)
        })

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
    }

    logout() {
        this.authBloc.logout()
    }
}
</script>
