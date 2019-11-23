import {Component, Prop, Vue} from "vue-property-decorator";

@Component({
    props: ['provides'],
    provide() {
        // @ts-ignore
        return this.provides;
    }
})
export default class VueBlocProvider extends Vue {

    @Prop()
    private provides?: {};

    render() {
        // @ts-ignore
        return this.$slots.default;
    }
}
