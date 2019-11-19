import {Vue} from "vue-property-decorator";

export default class VueBloc {
    protected $vue: Vue;

    constructor(vue: Vue) {
        this.$vue = vue;
    }
}
