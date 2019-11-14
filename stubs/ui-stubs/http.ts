import Vue from 'vue';
import axios from 'axios';

interface AxiosPluginOptions {
}

export function AxiosPlugin(v: typeof Vue, options: any): void {

    const httpClient = axios.create({
        timeout: 30000,
    });

    v.prototype.$http = httpClient;
}
