import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from "./components/user/Login";
import Category from "./components/Category";
import Register from "./components/user/Register";
import Forum from "./components/Forum";
import QuestionDetail from "./components/QuestionDetail";
import QuestionCreate from "./components/QuestionCreate";
import QuestionEdit from "./components/QuestionEdit";
import CategoryCreate from "./components/category/CategoryCreate";
import NotificationList from "./components/notification/NotificationList";
import MainPage from "./components/MainPage";


Vue.use(VueRouter)
const routes = [
    { path: '/', component: MainPage, name: 'welcome' },
    { path: '/login', component: Login, name: 'login' },
    { path: '/category', component: Category, name: 'category'},
    { path: '/register', component: Register, name: 'register'},
    { path: '/forum', component: Forum, name: 'forum'},
    { path: '/question/create', component: QuestionCreate, name: 'questions.create'},
    { path: '/question/:slug', component: QuestionDetail, name: 'questions.show'},
    { path: '/question/edit/:slug', component: QuestionEdit, name: 'questions.edit'},
    { path: '/categories/create', component: CategoryCreate, name: 'categories.create'},
    { path: '/notifications', component: NotificationList, name: 'notifications.index'}
]

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history'
})

export default router
