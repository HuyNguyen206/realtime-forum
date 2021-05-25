<template>
        <v-form
            ref="form"
        >

            <v-text-field
                v-model="email"
                label="E-mail"
                required
                type="email"
            ></v-text-field>
            <v-text-field
                v-model="password"
                label="password"
                required
                type="password"
            ></v-text-field>

            <v-checkbox
                v-model="remember"
                label="Remember?"
            ></v-checkbox>

            <v-btn
                color="success"
                class="mr-4"
                @click="login"
            >
                Login
            </v-btn>
        </v-form>
</template>

<script>
export default {
    name: "Login",
    data(){
        return {
            email:null,
            password:null
        }
    },
    methods: {
        login(){
            axios.post('/api/login', {
                email: this.email,
                password: this.password
            })
            .then(res => {
                console.log(res)
            })
            .catch(err => {
                console.log(err.response)
            })
        }
    }
}
</script>

<style scoped>

</style>
