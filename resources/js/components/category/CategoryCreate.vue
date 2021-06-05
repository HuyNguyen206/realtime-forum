<template>
    <v-container>
        <v-form ref="form">
            <v-text-field
                v-model="name"
                label="Category name"
                :rules="[!errors.name || errors.name[0]]"
                required
                type="email"
            ></v-text-field>
            <v-btn
                type="submit"
                color="success"
                class="mr-4 mt-2"
                @click.prevent="createCategory"
            >
                Create
            </v-btn>

        </v-form>
    </v-container>
</template>

<script>
import CheckLogin from "../mixins/CheckLogin";

export default {
    name: "CategoryCreate",
    mixins: [CheckLogin],
    data(){
       return {
           name: null
       }
    },
    methods:{
        createCategory(){
            axios.post(`/api/categories`, {name: this.name})
            .then(res => {
                this.$toastr.s('Category was created success', 'Success')
                this.$router.push({name: 'forum'})
            })
            .catch(err => {
                console.log(err.response)
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
