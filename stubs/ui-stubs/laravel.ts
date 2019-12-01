import Vue from 'vue';

interface LaravelPluginOptions {
}

export function LaravelPlugin(v: typeof Vue, options: LaravelPluginOptions): void {
    let appName = '';
    let userName = '';
    let isAuth = false;

    const appNameElement: HTMLMetaElement | null = document.head.querySelector('meta[name="app-name"]');
    const userNameElement: HTMLMetaElement | null = document.head.querySelector('meta[name="user-name"]');
    const isAuthElement: HTMLMetaElement | null = document.head.querySelector('meta[name="is-auth"]');

    if (appNameElement) {
        appName = appNameElement.content;
    }

    if (userNameElement) {
        userName = userNameElement.content;
    }

    if (isAuthElement) {
        isAuth = isAuthElement.content === 'true';
    }

    v.prototype.$laravel = {
        appName: appName,
        userName: userName,
        isAuth: isAuth,
    };
}
