export default {
    created() {
        if (!User.loginAlready()) {
            this.$router.push({name: 'login'})
        }
    },
    data(){
        return {
            errors: [],
        }
    }
}
