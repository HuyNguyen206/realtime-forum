/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import EventBus from "./EventBus";

require('./bootstrap');

window.Vue = require('vue');
import vuetify from './plugins/vuetify.js' // path to vuetify export
import router from "./router";
import User from './helpers/user'

window.User = User
import StorageApp from './helpers/storage'

window.StorageApp = StorageApp
import Token from './helpers/token'

window.Token = Token
import VueSimplemde from 'vue-simplemde'
import 'simplemde/dist/simplemde.min.css'
import VueToastr from "vue-toastr";
// use plugin
Vue.use(VueToastr);
import md from 'marked'
window.md = md

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('home', require('./components/Home.vue').default);
Vue.component('vue-simplemde', VueSimplemde)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    created(){
        axios.interceptors.request.use(
            (request) => {
                request.headers['Authorization'] = localStorage.getItem('token') ? `Bearer ${JSON.parse(localStorage.getItem('token')).access_token}` : null
                return request
            },
            (error) => {
                return Promise.reject(error);
            }
        )

        axios.interceptors.response.use(
            (response) => {
                console.log('onfull fulled')
                return response;
            },
            (error) => {
                if(error.response.status != 422){
                    let data = error.response.data.data
                    this.$toastr.e(data.message,'Error')
                    if(data.isJwt){
                            User.logout();
                            EventBus.$emit('isLogin', false)
                            this.$router.push({name: 'login'})
                    }

                }
                return Promise.reject(error)
            }
        )
    }
});
