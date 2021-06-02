<template>
    <v-container>
        <v-alert
            v-model="alert_success"
            dismissible
            type="success"
        >
            Question created successful!
        </v-alert>
        <v-alert type="error"
                 v-model="alert_error"
                 dismissible
        >
            {{ errorMessage }}
        </v-alert>
        <v-form ref="form">
            <v-text-field
                v-model="form.title"
                label="Title"
                :rules="[!errors.title || errors.title[0]]"
                required
                type="email"
            ></v-text-field>
            <v-textarea
                v-model="form.body"
                label="Body"
                :rules="[!errors.body || errors.body[0]]"
            ></v-textarea>
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
import EventBus from "../EventBus";
export default {
    name: "QuestionCreate",
    data() {
        return {
            categories: [],
            form: {
                title: null,
                body: null,
                category_id: null
            },
            errors: [],
            alert_success: false,
            alert_error: false,
            errorMessage: null
        }
    },
    created() {
        if(!User.loginAlready()){
            this.$router.push({name : 'login'})
        }
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
            axios.post('/api/questions', this.form, {
                headers: {
                    Authorization: `Bearer ${StorageApp.getToken()}`
                }
            })
                .then(res => {
                    this.alert_success = true
                })
                .catch(err => {
                    if(err.response.status != 422){
                        this.errorMessage = err.response.data.message
                        this.alert_error = true
                        if(err.response.data.message == "Token has expired"){
                            setTimeout(() => {
                                User.logout();
                                EventBus.$emit('isLogin', false)
                                this.$router.push({name: 'login'})
                            }, 1000)
                        }
                    }
                    else{
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
