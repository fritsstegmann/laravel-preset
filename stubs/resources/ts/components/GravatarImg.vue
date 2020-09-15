<template>
    <img
        class="rounded-full"
        :src="url"
        :alt="email"
    />
</template>

<script lang="ts">
import md5 from 'md5';
import {Component, Prop, Vue} from 'vue-property-decorator';

@Component({
    inheritAttrs: false,
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

    get url(): string {
        const img = [
            '//www.gravatar.com/avatar/',
            this.hash || md5(this.email.trim().toLowerCase()),
            `?s=${this.size}`,
            `&d=${this.defaultImg}`,
            `&r=${this.rating}`,
        ];

        return img.join('');
    }
}
</script>
