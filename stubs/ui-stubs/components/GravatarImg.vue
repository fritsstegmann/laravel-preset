<template>
    <img
        class="rounded-full"
        :src="url"
        :alt="email"
        @load="onLoad"
        @error="onError"
    />
</template>

<script lang="ts">
// @ts-ignore
import md5 from 'md5';
import {Component, Prop, Vue} from "vue-property-decorator";

@Component({
    inheritAttrs: false
})
export default class GravatarImg extends Vue {

    @Prop({default: ''})
    private email!: string

    @Prop({default: ''})
    private hash!: string

    @Prop({default: 80})
    private size!: number

    @Prop({default: ''})
    private defaultImg!: string

    @Prop({default: 'g'})
    private rating!: string

    @Prop({default: 'Avatar'})
    private alt!: string

    get url() {
        const img = [
            '//www.gravatar.com/avatar/',
            this.hash || md5(this.email.trim().toLowerCase()),
            `?s=${this.size}`,
            `&d=${this.defaultImg}`,
            `&r=${this.rating}`,
        ];

        return img.join('');
    }

    onLoad(...args: any) {
        this.$emit('load', ...args);
    }

    onError(...args: any) {
        this.$emit('error', ...args);
    }
}
</script>
