<template>
    <v-container fluid>
        <v-row>
            <v-col cols="7">
                <question v-for="question in questions" :question="question" :key="question.id"></question>
            </v-col>
            <v-col>
                Sidebar
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import Question from "./Question";

export default {
    name: "Forum",
    components: {Question},
     data() {
        return {
            questions: {}
        }
    },
    created() {
        axios.get('/api/questions')
            .then(res => {
                this.questions = res.data.data
            })
            .catch(err => {
                alert(err.response.statusText)
            })
    }
}
</script>

<style scoped>

</style>
