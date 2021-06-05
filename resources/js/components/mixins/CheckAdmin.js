export default {
    created() {
        if (!User.isAdmin()) {
            this.$router.push({name: 'forum'})
        }
    }
}
