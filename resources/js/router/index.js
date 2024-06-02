import { createRouter, createWebHistory } from "vue-router";

import Home from "../components/pages/Home.vue";
import Login from './../components/pages/auth/Login.vue';
import Register from './../components/pages/auth/Register.vue';
import Task from './../components/pages/dashboard/Task.vue';

const routes = [
    {
        path: '',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    },
    {
        path: '/home',
        name: 'home',
        component: Home
    },
    {
        path: '/tasks',
        name: 'Task',
        component: Task
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
