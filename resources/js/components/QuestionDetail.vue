<template>
    <div>
        <v-card
            v-if="questionDetail">
            <v-card-title>
                {{ questionDetail.title }}

                <v-spacer></v-spacer>
                <v-btn color="teal">{{questionDetail.replies_count}}</v-btn>
            </v-card-title>
            <v-card-subtitle class="pb-0">
                {{ questionDetail.created_at }}
            </v-card-subtitle>
            <v-card-subtitle class="pb-0 pt-0">
                by {{ questionDetail.user }}
            </v-card-subtitle>
            <v-card-text class="text--primary" v-html="questionDetail.body">
            </v-card-text>

            <v-card-actions v-if="isOwnQuestion">
                <router-link :to="{name : 'questions.edit', params:{slug: this.questionDetail.slug}}">
                    <v-btn
                        class="ma-2"
                        fab
                    >
                        <v-icon color="indigo">mdi-pencil</v-icon>
                    </v-btn>
                </router-link>

                <v-btn @click="deleteQuestion"
                >
                    <v-icon color="red">mdi-trash-can-outline</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
        <v-card
            v-if="questionDetail">
            <v-card-title>
                Replies
                <v-spacer></v-spacer>
            </v-card-title>
            <div v-for="(reply, index) in questionDetail.replies"  :key="index">
                <v-divider
                    v-if="index != 0"
                ></v-divider>
                <reply :reply="reply"></reply>
            </div>
        </v-card>
    </div>
</template>
<script>
import Reply from "./replies/Reply";
export default {
    name: "QuestionDetail",
    components: {Reply},
    data() {
        return {
            questionDetail: this.$route.params.questionDetail || null,
        }

    },
    computed: {
        isOwnQuestion() {
           return  User.isOwnQuestion(this.questionDetail.user_id)
        }
    },
    methods:{
        deleteQuestion(){
            axios.delete(`/api/questions/${this.questionDetail.slug}`)
            .then(res => {
                this.$toastr.s('Delete question success', 'Success')
                this.$router.push({name :'forum'})
            })
            .catch(err => {
                console.log(err.response)
            })
        }
    },
    created() {
        if (!this.questionDetail) {
            axios.get(`/api/questions/${this.$route.params.slug}`)
                .then(res => {
                    this.questionDetail = res.data.data
                })
                .then(() => {
                    this.questionDetail.body = md.parse(this.questionDetail.body)
                })
        } else {
            this.questionDetail.body = md.parse(this.questionDetail.body)
        }
    }
}
</script>

<style scoped>

</style>
