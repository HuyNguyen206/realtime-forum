<template>
    <div id="inspire">
        <v-parallax
            fill-height
            dark
            src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
            height="700"
        >
            <v-row
                align="center"
                justify="center"
            >
                <v-col
                    class="text-center"
                    cols="12"
                >
                    <h1 class="text-h3  font-weight-thin mb-4">
                        Real time SPA Forum
                    </h1>
                    <h4 class="text-h4">
                        Build your application today!
                    </h4>
                </v-col>
            </v-row>
        </v-parallax>
    </div>

</template>

<script>
export default {
    name: "MainPage"
}
</script>

<style scoped>
.v-parallax {
    height: 100vh !important;
}
</style>
