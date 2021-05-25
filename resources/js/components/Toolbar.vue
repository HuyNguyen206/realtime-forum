<template>
        <v-toolbar dense style="margin: 10px" >
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-spacer></v-spacer>
                <div style="margin: 10px 0; display: flex; align-items: center">
                    <router-link to="/foo"> <v-btn >Forum</v-btn></router-link>
                    <router-link to="/bar"><v-btn >Ask question</v-btn></router-link>
                    <router-link :to="{name: 'category'}"><v-btn >Category</v-btn></router-link>
                    <router-link :to="{name: 'login'}"><v-btn >Login</v-btn></router-link>
                </div>
        </v-toolbar>
</template>
<script>
export default {
    name: "Toolbar"
}
</script>

<style scoped>

</style>
