<template>
        <v-card>
            <v-toolbar
                color="cyan"
                dark
            >
                <v-app-bar-nav-icon></v-app-bar-nav-icon>

                <v-toolbar-title>Category</v-toolbar-title>

                <v-spacer></v-spacer>

                <v-btn icon>
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
            </v-toolbar>

            <v-list three-line>
                <template v-for="(item, index) in categories">
                    <v-divider
                        v-if="index != 0"
                    ></v-divider>
                    <v-list-item
                        :key="index"
                    >
                        <v-list-item-content>
                            <v-list-item-title v-text="item.name"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
        </v-card>
</template>

<script>
export default {
    name: "SideBar",
    data(){
        return{
            categories: []
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
