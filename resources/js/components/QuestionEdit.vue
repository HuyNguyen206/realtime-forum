<template>
    <v-container>
        <v-form ref="form">
            <v-text-field
                v-model="form.title"
                label="Title"
                :rules="[!errors.title || errors.title[0]]"
                required
                type="email"
            ></v-text-field>
            <vue-simplemde v-model="form.body" ref="markdownEditor"/>
            <v-select
                v-model="form.category_id"
                :rules="[!errors.category_id || errors.category_id[0]]"
                :items="categories"
                item-text="name"
                item-value="id"
                label="Select category"
                persistent-hint
                autocomplete
            ></v-select>
            <v-btn
                type="submit"
                color="success"
                class="mr-4 mt-2"
                @click.prevent="updateQuestion"
            >
                Update
            </v-btn>
            <router-link style="text-decoration: none" :to="{name: 'questions.show', params:{slug:this.$route.params.slug}}">
                <v-btn
                    color="success"
                    class="mr-4 mt-2"
                >
                    Cancel
                </v-btn>
            </router-link>


        </v-form>
    </v-container>
</template>

<script>
import CheckLogin from "./mixins/CheckLogin";

export default {
    name: "QuestionEdit",
    mixins: [CheckLogin],
    data() {
        return {
            form: {
                title: null,
                body: null,
                category_id: null,
            },
            categories: [],
        }
    },
    methods:{
        updateQuestion(){
            axios.put(`/api/questions/${this.$route.params.slug}`, this.form)
            .then(res => {
                this.$toastr.s('Update question success', 'Success')
                this.$router.push({name:'questions.show', params:{slug: this.toSlug()}})
            })
            .catch(err => {
                this.errors = err.response.data.errors
            })
        },
        toSlug(){
            return this.form.title
                .toLowerCase()
                .replace(/[^\w ]+/g,'')
                .replace(/ +/g,'-')
                ;
        }
    },
    created() {
        axios.get('/api/categories')
            .then(res => {
                this.categories = res.data.data
            })
            .catch(err => {
                alert(err.response.statusText)
            })
        axios.get(`/api/questions/${this.$route.params.slug}`)
            .then(res => {
                this.form.title = res.data.data.title
                this.form.body = res.data.data.body
                this.form.category_id = res.data.data.category_id
            })
            .catch(err => {
                console.log(err.response)
            })
    }
}
</script>

<style scoped>

</style>
