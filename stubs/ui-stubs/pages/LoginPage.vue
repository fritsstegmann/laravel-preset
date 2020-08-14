<template>
    <div class="container m-auto">
        <div class="flex justify-center">
            <div class="sm:mt-20">
                <div class="mt-2 pt-4 pb-4 sm:pb-8 px-8 sm:bg-white rounded sm:shadow">
                    <form method="POST" action="/login" @submit.prevent.stop="login">
                        <div class="mt-4">
                            <label for="email" class="text-gray-700">Email</label>

                            <div class="mt-2">
                                <input v-model="username" id="email" type="email"
                                       class="py-2 px-4 w-full sm:w-64 min-w-full outline-none focus:shadow-outline rounded border-gray-500 bg-gray-100"
                                       name="email" value="" required autocomplete="email"
                                       placeholder="my email address" autofocus>
                            </div>
                        </div>

                        <div class="mt-8">
                            <label for="password" class="text-gray-700">Password</label>

                            <div class="mt-2">
                                <input v-model="password" id="password" type="password"
                                       class="py-2 px-4 w-full sm:w-64 min-w-full outline-none focus:shadow-outline rounded border-gray-500 bg-gray-100"
                                       name="password" autocomplete="current-password" placeholder="my password">
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit"
                                    class="py-2 px-4 w-full shadow outline-none focus:shadow-outline active:bg-gray-800 active:shadow-none hover:bg-gray-700 outline-none hover:shadow-lg rounded bg-gray-800 text-gray-200">
                                Login
                            </button>
                        </div>

                        <div class="mt-8 sm:flex">
                            <div class="flex-grow">
                            </div>
                            <div>
                                <a class="sm:ml-4 mt-4 block sm:mt-0 text-gray-600 underline hover:text-gray-800"
                                   href="/reset-password">
                                    Forgot your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-0 sm:mt-2 text-sm text-center w-full text-gray-700">
                    Don't have account, <a
                    class="font-medium text-gray-900 focus:shadow-outline outline-none hover:underline"
                    href="/register">Register</a> here
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import {Component, Inject, Vue} from "vue-property-decorator";
import AuthBloc from "../blocs/AuthBloc";

@Component
export default class LoginPage extends Vue {
    private username = ''
    private password = ''

    @Inject('authBloc')
    private authBloc!: AuthBloc

    public login() {
        this.authBloc.login(this.username, this.password).then((response) => {
            console.info('user logged in')
        })
    }
}
</script>

<style scoped>

</style>
