<template>
    <div>
        <v-card
            v-if="questionDetail">
            <v-card-title>
                {{ questionDetail.title }}

                <v-spacer></v-spacer>
                <v-btn color="teal">{{ repliesCount }}</v-btn>
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
        <div v-if="questionDetail">
            <v-card class="pb-2" v-if="isLoginAlready">
                <v-card-title >
                    New Reply
                    <v-spacer></v-spacer>
                </v-card-title>
                <div>
                </div>
                <v-divider></v-divider>
                <reply-create @replyCreate="updateReplies" :question_slug="questionDetail.slug"></reply-create>
            </v-card>
            <v-card v-else class="m-2 pl-2">
                <router-link :to="{name: 'login'}" style="text-decoration: none"> <v-btn color="green" dark>Login to reply</v-btn></router-link>
            </v-card>
            <v-card class="mt-2">
                <v-card-title>
                    Replies
                    <v-spacer></v-spacer>
                </v-card-title>
                <div v-for="(reply, index) in questionDetail.replies" :key="index">
                    <v-divider
                        v-if="index != 0"
                    ></v-divider>
                    <reply @replyLikeUpdate="updateReplies" @replyUpdate="updateReplies" @replyDelete="updateReplies" :reply="reply"
                           :index="index"></reply>
                </div>
            </v-card>
        </div>

    </div>
</template>
<script>
import Reply from "./replies/Reply";
import ReplyCreate from "./replies/ReplyCreate";

export default {
    name: "QuestionDetail",
    components: {Reply, ReplyCreate},
    data() {
        return {
            questionDetail: this.$route.params.questionDetail || null,
        }

    },
    computed: {
        repliesCount() {
            let replyCount = this.questionDetail.replies.length
            return replyCount + ' ' + (replyCount > 1 ? 'replies' : 'reply')
        },
        isOwnQuestion() {
            return User.isOwnQuestion(this.questionDetail.user_id)
        },
        isLoginAlready() {
            return User.loginAlready()
        }
    },
    methods: {
        deleteQuestion() {
            axios.delete(`/api/questions/${this.questionDetail.slug}`)
                .then(res => {
                    this.$toastr.s('Delete question success', 'Success')
                    this.$router.push({name: 'forum'})
                })
                .catch(err => {
                    console.log(err.response)
                })
        },
        updateReplies(data) {
            // newReply can be either object or index
            switch (data.type) {
                case 'create':
                    this.questionDetail.replies.unshift(data.reply)
                    break
                case 'delete':
                    this.questionDetail.replies.splice(data.index, 1)
                    break
                case 'update':
                    this.questionDetail.replies.splice(data.index, 1, data.reply)
                    break
                case 'likeToggleReply':
                    this.$set(this.questionDetail.replies, data.index, data.reply)
                    // this.questionDetail.replies.splice(data.index, 1, data.reply)
                    // this.questionDetail.replies[data.index] = data.reply
                    break
            }
            // if (typeof newReply === 'object' && newReply !== null) {
            //     this.questionDetail.replies.unshift(newReply)
            // }
            // //Remove question
            // else {
            //     this.questionDetail.replies.splice(newReply, 1)
            // }

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
        if(User.loginAlready()){
            Echo.private('App.User.' + User.userInfo().id)
                .notification((notification) => {
                    this.questionDetail.replies.unshift(notification.reply)
                });
        }
    }
}
</script>

<style scoped>

</style>
