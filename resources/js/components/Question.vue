<template>
    <v-card>
        <v-card-title>
            <router-link :to="{ name: 'questions.show', params:{slug: question.slug, questionDetail: question}}">
                {{ question.title }}
            </router-link>
        </v-card-title>
        <v-card-subtitle class="pb-0">
            {{ question.created_at }}
        </v-card-subtitle>
        <v-card-subtitle class="pb-0 pt-0">
            by {{ question.user }}
        </v-card-subtitle>
        <v-card-actions>
            <v-btn
                color="orange"
                text
            >
                Share
            </v-btn>

            <v-btn
                color="orange"
                text
            >
                Explore
            </v-btn>
        </v-card-actions>
    </v-card>
</template>


<script>
export default {
    name: "Question",
    props: ['question']
}
</script>

<style scoped>

</style>
