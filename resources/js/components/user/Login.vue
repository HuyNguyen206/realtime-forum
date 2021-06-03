<template>
    <v-container>
        <v-form
            ref="form"
        >

            <v-text-field
                v-model="email"
                label="E-mail"
                :rules = "[!errors.email || errors.email[0]]"
                required
                type="email"
            ></v-text-field>
            <v-text-field
                v-model="password"
                label="password"
                :rules = "[!errors.password || errors.password[0]]"
                required
                type="password"
            ></v-text-field>

            <!--            <v-checkbox-->
            <!--                v-model="remember"-->
            <!--                label="Remember?"-->
            <!--            ></v-checkbox>-->

            <v-btn
                type="submit"
                color="success"
                class="mr-4 mt-2"
                @click.prevent="login"
            >
                Login
            </v-btn>

            <router-link :to="{name:'register'}">
                <v-btn
                    color="primary"
                    class="mr-4 mt-2"
                >
                    Register
                </v-btn>
            </router-link>
        </v-form>
    </v-container>

</template>

<script>
export default {
    name: "Login",
    created() {
      if(User.loginAlready()){
          this.$router.push({name : 'forum'})
      }
    },
    data() {
        return {
            email: null,
            password: null,
            errors:{}
        }
    },
    methods: {
        login() {
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password
                })
                    .then(res => {
                        User.repsonseLoginHandle(res)
                    })
                    .catch(err => {
                            this.errors = err.response.data.errors
                            this.$refs.form.validate()
                    })
        }
    },
    // mounted() {
    //     console.log(baseURL)
    //     console.log(User.hasValidToken(), User.loginAlready(), User.userInfo())
    // }
}
</script>

<style scoped>

</style>
