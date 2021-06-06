<template>
    <div class="px-2">
        <vue-simplemde v-model="body"></vue-simplemde>
        <v-btn color="green" dark @click="addReply">
            Add reply
        </v-btn>
    </div>
</template>

<script>
export default {
    name: "ReplyCreate",
    props: ['question_slug'],
    data() {
        return {
            body: null
        }
    },
    methods:{
        addReply(){
            axios.post(`/api/questions/${this.question_slug}/replies`, {body: this.body})
            .then(res => {
                this.body = ''
                let reply = res.data.data
                this.$toastr.s('Reply was created success', 'Success')
                this.$emit('replyCreate',{reply, type: 'create'})
            })
            .catch(err => console.log(err.response))
        }
    }
}
</script>

<style scoped>

</style>
