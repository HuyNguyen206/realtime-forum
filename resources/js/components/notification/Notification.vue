<template>
    <div class="mr-6">
        <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">

                <v-btn
                    icon
                    dark
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-tab>
                        <v-badge
                            color="green"
                            :content="count"
                            :value="count"
                        >
                            <v-icon color="red">
                                notifications
                            </v-icon>
                        </v-badge>
                    </v-tab>
                </v-btn>

            </template>
            <v-list>
                <v-list-item link v-for="(notification, index) in notifications" :key="index">
                    <v-list-item-title @click="markAsRead(index)" v-text="notification.data.message">}</v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <router-link style="text-decoration: none" :to="{name:'notifications.index'}">Go to notification page
                    </router-link>
                </v-list-item>

            </v-list>
        </v-menu>
    </div>
</template>

<script>
export default {
    name: "Notification",
    data(){
        return {
            notifications: []
        }
    },
    created() {
        if(User.loginAlready()){
            axios.get(`/api/notifications/unread`)
                .then(res => {
                    this.notifications = res.data.data
                })
            .catch(err => {
                console.log(err.response)
            })
        }

    },
    computed: {
        count() {
        return this.notifications.length
        }
    },
    methods:{
        markAsRead(index){
            let notification = this.notifications[index]
            axios.patch(`/api/notifications/mark-as-read/${notification.id}`)
            .then(res => {
                this.notifications.splice(index, 1)
                this.$router.push({name: 'questions.show', params:{slug: notification.data.question.slug}})
            })
            .catch(err => {
                console.log(err.response)
            })

        }
    }
}
</script>

<style scoped>

</style>
