<template>
    <v-container fluid>
        <v-row>
            <v-col cols="7">
                <question class="mt-2" v-for="question in questions" :question="question" :key="question.id"></question>
            </v-col>
            <v-col>
                <side-bar></side-bar>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import Question from "./Question";
import SideBar from "./SideBar";

export default {
    name: "Forum",
    components: {Question, SideBar},
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
