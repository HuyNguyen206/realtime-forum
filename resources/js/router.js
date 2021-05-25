import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from "./components/Login";
import Category from "./components/Category";

Vue.use(VueRouter)
const routes = [
    { path: '/login', component: Login, name: 'login' },
    { path: '/category', component: Category, name: 'category'}
]

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history'
})

export default router
