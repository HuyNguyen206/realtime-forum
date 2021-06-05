<template>
    <div>
        <v-card-subtitle class="pb-0">
            {{ reply.created_at }}
        </v-card-subtitle>
        <v-card-subtitle class="pb-0 pt-0">
            by {{ reply.user }}
        </v-card-subtitle>
        <v-card-text class="text--primary" v-html="reply.body">
        </v-card-text>
    </div>
</template>

<script>
export default {
    name: "Reply",
    props: ['reply']
}
</script>

<style scoped>

</style>
