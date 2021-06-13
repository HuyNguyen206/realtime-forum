<template>
    <v-container fluid>
        <v-row>
            <v-col cols="7">
                <question class="mt-2" v-for="question in questions" :question="question" :key="question.id"></question>
                <div class="text-center mt-2">
                    <v-pagination v-if="numberOfPage"
                                  @input="changePage"
                        v-model="page"
                        :length="numberOfPage"
                    ></v-pagination>
                </div>
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
            questions: {},
            page: 1,
            numberOfPage: null,
        }
    },
    created() {
      this.getQuestions()
    },
    methods:{
        changePage(){
            this.getQuestions(this.page)
        },
        getQuestions(page = 1){
            axios.get(`/api/questions?page=${page}`)
                .then(res => {
                    let data = res.data
                    this.questions = data.data
                    this.numberOfPage = data.meta.last_page

                })
                .catch(err => {
                    alert(err.response.statusText)
                })
        }
    }
}
</script>

<style scoped>

</style>
