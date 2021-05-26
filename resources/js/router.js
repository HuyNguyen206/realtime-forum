import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from "./components/user/Login";
import Category from "./components/Category";
import Register from "./components/user/Register";
import Forum from "./components/Forum";

Vue.use(VueRouter)
const routes = [
    { path: '/login', component: Login, name: 'login' },
    { path: '/category', component: Category, name: 'category'},
    { path: '/register', component: Register, name: 'register'},
    { path: '/forum', component: Forum, name: 'forum'}
]

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history'
})

export default router
