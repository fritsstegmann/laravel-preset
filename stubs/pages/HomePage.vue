<template>
    <div>
        <Header></Header>
        <div class="container m-auto">
            <div class="py-2 uppercase tracking-wider text-sm text-gray-600 rounded">Dashboard</div>
            <div class="bg-white shadow rounded">
                <div class="p-4 text-gray-800">
                    <span>Hello World</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import {Component, Vue} from "vue-property-decorator";
import Header from "../components/Header.js";

@Component({
    components: {Header}
})
export default class HomePage extends Vue {
}
</script>
