import {AxiosStatic} from 'axios';


declare module 'vue/types/vue' {
    interface Vue {
        $laravel: {
            appName: string,
            userName: string,
            isAuth: boolean,
        };
    }
}
