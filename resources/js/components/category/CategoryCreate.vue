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
            <v-btn v-if="!editSlug"
                type="submit"
                color="success"
                class="mr-4 mt-2"
                @click.prevent="createCategory"
            >
                Create
            </v-btn>
            <v-btn v-else
                type="submit"
                color="success"
                class="mr-4 mt-2"
                @click.prevent="updateCategory"
            >
               Update
            </v-btn>

        </v-form>
        <v-card class="mt-2">
            <v-toolbar
                color="cyan"
                dark
            >
                <v-app-bar-nav-icon></v-app-bar-nav-icon>

                <v-toolbar-title>Category</v-toolbar-title>

                <v-spacer></v-spacer>
            </v-toolbar>

            <v-list three-line>
                <template v-for="(item, index) in categories">
                    <v-divider
                        v-if="index != 0"
                    ></v-divider>
                    <v-list-item :class="{'blue':editIndex == index ,'lighten-4': editIndex == index}"
                        :key="index"
                    >
                        <v-list-item-content >
                            <v-list-item-title  v-text="item.name"></v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-action>
                            <v-btn icon @click="editCategory(index)">
                                <v-icon color="green lighten-1">mdi-pencil</v-icon>
                            </v-btn>
                        </v-list-item-action>
                        <v-list-item-action>
                            <v-btn icon @click="deleteCategory(item.slug, index)">
                                <v-icon color="red lighten-1">mdi-trash-can-outline</v-icon>
                            </v-btn>
                        </v-list-item-action>
                    </v-list-item>
                </template>
            </v-list>
        </v-card>
    </v-container>
</template>

<script>
import CheckLogin from "../mixins/CheckLogin";
import CheckAdmin from "../mixins/CheckAdmin";

export default {
    name: "CategoryCreate",
    mixins: [CheckLogin, CheckAdmin],
    data(){
       return {
           editIndex: null,
           editSlug: null,
           name: null,
           categories:[]
       }
    },
    methods:{
        createCategory(){
            axios.post(`/api/categories`, {name: this.name})
            .then(res => {
                this.$toastr.s('Category was created success', 'Success')
                this.categories.unshift(res.data.data)
                this.name=null
            })
            .catch(err => {
                console.log(err.response)
                if(err.response.status == 422){
                    this.errors = err.response.data.errors
                    this.$refs.form.validate()
                }
            })
        },
        deleteCategory(slug, index){
            axios.delete(`/api/categories/${slug}`)
            .then(res => {
                this.$toastr.s('Delete category success', 'Success');
                this.categories.splice(index,1)
            })
            .catch(err => {
                console.log(err.response)
            })
        },
        editCategory(index){
            let item = this.categories[index]
            this.editSlug = item.slug
            this.name = item.name
            this.editIndex = index
        },
        updateCategory(){
            axios.put(`/api/categories/${this.editSlug}`, {name: this.name})
            .then(res => {
                this.$toastr.s('Update category success', 'Success')
                this.categories.splice(this.editIndex, 1, res.data.data)
            })
            .catch(err => {
                console.log(err.response)
            })
        }
    },
    computed:{
      action(){
          return this.isCreate ? 'Create' : 'Update'
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
    }
}
</script>

<style scoped>

</style>
