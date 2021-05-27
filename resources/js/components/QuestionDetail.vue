<template>
    <v-card
    >
        <v-card-title>
            {{questionDetail.title}}

        <v-spacer></v-spacer>
            <v-btn color="teal">5 Replies</v-btn>
        </v-card-title>
        <v-card-subtitle class="pb-0">
            {{questionDetail.created_at}}
        </v-card-subtitle>
        <v-card-subtitle class="pb-0 pt-0">
            by {{questionDetail.user}}
        </v-card-subtitle>
        <v-card-text class="text--primary" v-html="questionDetail.body">
        </v-card-text>

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
    name: "QuestionDetail",
    data(){
        return {
            questionDetail: this.$route.params.questionDetail || null
        }

    },
    created() {
        if(!this.questionDetail){
            axios.get(`/api/questions/${this.$route.params.slug}`)
                .then(res => {
                    this.questionDetail = res.data.data
                })
        }
    }
}
</script>

<style scoped>

</style>
