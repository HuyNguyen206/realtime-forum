<template>
<div>
    <v-card v-for="(notification, index) in notifications" :key="index">
        <v-card-title>
            <router-link :to="{ name: 'questions.show', params:{slug: notification.data.question.slug}}">
                {{ notification.data.message }}
            </router-link>
        </v-card-title>
        <v-card-subtitle class="pb-0">
            {{ notification.created_at }}
        </v-card-subtitle>
    </v-card>
</div>
</template>

<script>
export default {
    name: "NotificationList",
    data(){
        return {
            notifications: []
        }
    },
    created() {
        axios.get('/api/notifications')
        .then(res => {
            this.notifications = res.data.data
        })
    }
}
</script>

<style scoped>

</style>
