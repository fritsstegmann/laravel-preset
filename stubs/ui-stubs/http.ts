import Vue from 'vue';
import axios from 'axios';

interface AxiosPluginOptions {
    timeout: number;
}

export function AxiosPlugin(v: typeof Vue, options: AxiosPluginOptions): void {
    let timeout = 10000;

    if (options && options.timeout) {
        timeout = options.timeout;
    }

    let token: HTMLMetaElement | null = document.head.querySelector('meta[name="csrf-token"]');

    if (token) {
        const _axios = axios.create({
            timeout: timeout,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token.content,
            }
        });

        v.prototype.$http = _axios;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
}
