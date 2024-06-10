import { createRouter, createWebHistory } from "vue-router";

import Home from "../components/pages/Home.vue";
import Login from './../components/pages/auth/Login.vue';
import Register from './../components/pages/auth/Register.vue';
import Task from './../components/pages/dashboard/Task.vue';
import TaskReception from "../components/pages/dashboard/TaskReception.vue";
import Profil from "../components/pages/dashboard/Profil.vue";

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login,
        meta: {guest: true}
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {requireAuth: true}
    },
    {
        path: '/home',
        name: 'home',
        component: Home,
        meta: {requiresAuth: true}
    },
    {
        path: '/tasks',
        name: 'Task',
        component: Task,
        meta: {requiresAuth: true}
    },
    {
        path: '/task-inbox',
        name: 'TaskReception',
        component: TaskReception,
        meta: {requiresAuth: true}
    },
    {
        path: '/profil',
        name: 'Profil',
        component: Profil,
        meta: {requiresAuth: true}
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
