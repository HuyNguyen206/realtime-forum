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
            <vue-simplemde v-model="form.body" ref="markdownEditor" />
<!--            <v-textarea-->
<!--                v-model="form.body"-->
<!--                label="Body"-->
<!--                :rules="[!errors.body || errors.body[0]]"-->
<!--            ></v-textarea>-->
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
                @click.prevent="createQuestion"
            >
                Create
            </v-btn>

        </v-form>
    </v-container>
</template>

<script>
import CheckLogin from "./mixins/CheckLogin";
export default {
    name: "QuestionCreate",
    mixins: [CheckLogin],
    data() {
        return {
            categories: [],
            form: {
                title: null,
                body: null,
                category_id: null
            },
            // alert_success: false,
            alert_error: false,
            errorMessage: null
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
    },
    methods: {
        createQuestion() {
            axios.post('/api/questions', this.form)
                .then(res => {
                    this.$toastr.s('Question created successful', 'Success')
                    this.$router.push({name: 'forum'})
                })
                .catch(err => {
                    if(err.response.status == 422){
                        this.errors = err.response.data.errors
                        this.$refs.form.validate()
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
