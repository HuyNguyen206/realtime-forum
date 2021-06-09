<template>
    <v-toolbar color="indigo" dark dense style="margin: 10px">
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <v-spacer></v-spacer>
        <notification @markAsRead="markAsRead" :notifications="notifications" v-if="loginAlready"></notification>
        <div style="margin: 10px 0; display: flex; align-items: center">
            <router-link :to="{name: 'forum'}" style="text-decoration: none">
                <v-btn icon class="px-14">Forum</v-btn>

            </router-link>
            <router-link v-if="loginAlready" :to="{name: 'questions.create'}" style="text-decoration: none">
                <v-btn icon class="px-14">Ask question</v-btn>
            </router-link>
            <router-link v-if="isAdmin" :to="{name: 'categories.create'}" style="text-decoration: none">
                <v-btn icon class="px-14">Category</v-btn>
            </router-link>
            <router-link v-if="!loginAlready" :to="{name: 'login'}" style="text-decoration: none">
                <v-btn icon class="px-14">Login</v-btn>
            </router-link>
            <router-link v-if="!loginAlready" :to="{name: 'register'}" style="text-decoration: none">
                <v-btn icon class="px-14" >Register</v-btn>
            </router-link>
            <a href='' v-if="loginAlready" @click.prevent="logout" style="text-decoration: none">
                <v-btn icon class="px-14">Logout</v-btn>
            </a>
        </div>
    </v-toolbar>
</template>
<script>
import EventBus from "../EventBus";
import Notification from "./notification/Notification";

export default {
    name: "Toolbar",
    components: {Notification},
    created() {
        EventBus.$on('isLogin', (isLogin) => {
            this.loginAlready = isLogin
            this.isAdmin = User.isAdmin()
            if(isLogin){
                axios.get(`/api/notifications/unread`)
                    .then(res => {
                        this.notifications = res.data.data
                    })
                this.subscribeChannel()
            }
        })
        if (this.loginAlready) {
            axios.get(`/api/notifications/unread`)
                .then(res => {
                    this.notifications = res.data.data
                })
            this.subscribeChannel()
        }
    },
    data() {
        return {
            loginAlready: User.loginAlready(),
            isAdmin: User.isAdmin(),
            notifications: []
        }
    },
    methods: {
        subscribeChannel(){
            Echo.connector.pusher.config.auth.headers.Authorization = 'Bearer ' + StorageApp.getToken()
            Echo.private('App.User.' + User.userInfo().id)
                .notification((notification) => {
                    this.notifications.unshift(notification)
                    this.$toastr.s(notification.data.message, 'Notification')
                    // Echo.leaveChannel('App.User.' + User.userInfo().id);
                    console.log(notification.type);
                });
        },
        markAsRead(index){
            let notification = this.notifications[index]
            this.notifications.splice(index,1)
            this.$router.push({name: 'questions.show', params: {slug: notification.data.question.slug}})
        },
        logout() {
            axios.post('/api/auth/logout')
                .then(res => {
                    let channel = 'App.User.' + User.userInfo().id
                    User.logout();
                    // location.reload()
                    this.loginAlready = false
                    this.isAdmin = false
                    Echo.leave(channel);
                    // EventBus.$emit('isLogin', false)
                    this.$router.push({name: 'login'})
                })
        }
    },
}
</script>

<style scoped>

</style>
