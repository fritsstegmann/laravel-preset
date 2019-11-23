import Vue from 'vue';
import axios from 'axios';

interface AxiosPluginOptions {
    timeout: number;
}

export function AxiosPlugin(v: typeof Vue, options: AxiosPluginOptions): void {

    let timeout = 10000;

    if (options.timeout) {
        timeout = options.timeout;
    }

    v.prototype.$http = axios.create({
        timeout: timeout,

    });
}
