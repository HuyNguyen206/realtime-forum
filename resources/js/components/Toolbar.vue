<template>
    <v-toolbar dense style="margin: 10px">
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <v-spacer></v-spacer>
        <div style="margin: 10px 0; display: flex; align-items: center">
            <router-link :to="{name: 'forum'}">
                <v-btn>Forum</v-btn>
            </router-link>
            <router-link  v-if="loginAlready" :to="{name: 'questions.create'}">
                <v-btn>Ask question</v-btn>
            </router-link>
            <router-link :to="{name: 'categories.create'}">
                <v-btn>Add Category</v-btn>
            </router-link>
            <router-link v-if="!loginAlready" :to="{name: 'login'}">
                <v-btn>Login</v-btn>
            </router-link>
            <router-link v-if="!loginAlready" :to="{name: 'register'}">
                <v-btn>Register</v-btn>
            </router-link>
            <a href='' v-if="loginAlready" @click.prevent="logout">
                <v-btn>Logout</v-btn>
            </a>
        </div>
    </v-toolbar>
</template>
<script>
import EventBus from "../EventBus";
export default {
    name: "Toolbar",
    created() {
        EventBus.$on('isLogin', (isLogin) => {
            this.loginAlready = isLogin
        })
    },
    data() {
        return {
            loginAlready: User.loginAlready()
        }
    },
    methods: {
        logout() {
            axios.post('/api/auth/logout')
            .then(res => {
                User.logout();
                // location.reload()
                this.loginAlready = false
                // EventBus.$emit('isLogin', false)
                this.$router.push({name: 'login'})
            })
        }
    },
}
</script>

<style scoped>

</style>
