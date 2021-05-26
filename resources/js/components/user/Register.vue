<template>
    <v-form
        ref="form"
    >
        <v-text-field
            v-model="user.name"
            label="Name*"
            required
            :rules = "[!errors.name || errors.name[0]]"
            type="text"
        ></v-text-field>
        <v-text-field
            v-model="user.email"
            label="E-mail"
            required
            :rules = "[!errors.email || errors.email[0]]"
            type="email"
        ></v-text-field>
        <v-text-field
            v-model="user.password"
            label="Password"
            required
            :rules = "[!errors.password || errors.password[0]]"
            type="password"
        ></v-text-field>
        <v-text-field
            v-model="user.password_confirmation"
            label="Password confirmation"
            required
            type="password"
        ></v-text-field>

        <!--            <v-checkbox-->
        <!--                v-model="remember"-->
        <!--                label="Remember?"-->
        <!--            ></v-checkbox>-->

        <v-btn
            color="success"
            class="mr-4"
            @click.prevent="register"
            type="submit"
        >
            Register
        </v-btn>
        <router-link :to="{name:'login'}">
            <v-btn
                color="primary"
                class="mr-4"
            >
                Back to login
            </v-btn>
        </router-link>
    </v-form>
</template>

<script>
export default {
    name: "Register",
    created() {
        if(User.loginAlready()){
            this.$router.push({name : 'forum'})
        }
    },
    data(){
        return {
            user:{
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            },
            errors:{

            },
        }
    },
    methods:{
        register(){
            axios.post('/api/auth/register', this.user)
            .then((res) => User.repsonseLoginHandle(res))
            .catch(err =>{
                if(err.response.status == 422){
                    this.errors = err.response.data.errors
                    this.$refs.form.validate()
                }
                else{
                    alert(err.response.statusText)
                    console.log(err.response)
                }

            })
        }
    }
}
</script>

<style scoped>

</style>
