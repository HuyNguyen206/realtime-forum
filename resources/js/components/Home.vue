<template>
    <div>
        <toolbar></toolbar>
            <router-view></router-view>
        <app-footer></app-footer>
    </div>
</template>

<script>
import Toolbar from "./Toolbar";
import AppFooter from "./AppFooter";
import EventBus from "../EventBus";
export default {
    name: "Home",
    components: {AppFooter, Toolbar},
    data(){
        return {
            alert_success:false,
            alertMessage:null
        }
    }
}
</script>

<style scoped>

</style>
