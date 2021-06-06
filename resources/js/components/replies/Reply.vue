<template>
    <div>
        <v-card-title class="pt-0">
            <div>
                <v-card-subtitle class="pb-0">
                    {{ reply.created_at }}
                </v-card-subtitle>
                <v-card-subtitle class="pb-0 pt-0">
                    by {{ reply.user }}
                </v-card-subtitle>
            </div>
            <v-spacer>
            </v-spacer>

            <v-icon v-if="reply.is_like == null"  color="pink">favorite_border</v-icon>
            <v-btn v-else icon @click="toggleLike">
                <v-icon v-if="reply.is_like" color="pink" >favorite</v-icon>
                <v-icon v-else color="pink">favorite_border</v-icon>
            </v-btn>
            {{reply.like_count}}
        </v-card-title>

        <div v-if="editReplyBody">
            <vue-simplemde v-model="editReplyBody"></vue-simplemde>
            <v-card-actions>
                <!--            <router-link :to="{name : 'questions.edit', params:{slug: this.questionDetail.slug}}">-->
                <v-btn color="green" dark @click="updateReply">
                    Update
                </v-btn>
                <v-btn color="red" dark @click="editReplyBody = null">
                    Cancel
                </v-btn>
            </v-card-actions>
        </div>
        <div v-else>
            <v-card-text class="text--primary" v-html="parseBody">
            </v-card-text>
            <v-card-actions v-if="isOwnReply">
                <!--            <router-link :to="{name : 'questions.edit', params:{slug: this.questionDetail.slug}}">-->
                <v-btn
                    class="ma-2"
                    fab
                    @click="editReply"
                >
                    <v-icon color="indigo">mdi-pencil</v-icon>
                </v-btn>
                <!--            </router-link>-->

                <v-btn @click="deleteReply">
                    <v-icon color="red">mdi-trash-can-outline</v-icon>
                </v-btn>
            </v-card-actions>
        </div>
    </div>
</template>

<script>
export default {
    name: "Reply",
    props: ['reply', 'index'],
    data() {
        return {
            editReplyBody: null,
            // parseBody: md.parse(this.reply.body)
        }
    },
    computed: {
        isOwnReply() {
            return User.isOwnReply(this.reply.user_id)
        },
        parseBody() {
            return md.parse(this.reply.body)
        }
    },
    methods: {
        deleteReply() {
            axios.delete(`/api/replies/${this.reply.id}`)
                .then(res => {
                    this.$toastr.s('The reply was delete success', 'Success')
                    this.$emit('replyDelete', {index: this.index, type: 'delete'})
                })
        },
        editReply() {
            this.editReplyBody = this.reply.body
        },
        updateReply() {
            axios.patch(`/api/replies/${this.reply.id}`, {body: this.editReplyBody})
                .then(res => {
                    let reply = res.data.data
                    this.$toastr.s('The reply was update success', 'Success')
                    this.editReplyBody = null
                    this.$emit('replyUpdate', {reply, type: 'update', index: this.index})
                })
        },
        toggleLike(){
            axios.post(`/api/like/toggle/${this.reply.id}`)
            .then(res => {
                let message = this.reply.is_like ? 'You just dislike this reply' : 'You just like this reply'
                // let like_count = this.reply.is_like ? this.reply.like_count -1 :  this.reply.like_count + 1
                this.$toastr.s(message, 'Success')
                // let reply = {...this.reply}
                // reply.is_like = !this.reply.is_like
                // reply.like_count = like_count
                let reply = res.data.data
                this.$emit('replyLikeUpdate', {index:this.index, reply, type:'likeToggleReply'})
            })
        }
    }
}
</script>

<style scoped>

</style>
