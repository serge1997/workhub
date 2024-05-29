import { createRouter, createWebHistory } from "vue-router";

import Home from "../components/pages/Home.vue";
import Login from './../components/pages/auth/Login.vue';
import Register from './../components/pages/auth/Register.vue';

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/',
        name: 'home',
        component: Home
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
