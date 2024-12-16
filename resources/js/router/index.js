import { createRouter, createWebHistory } from "vue-router";


const routes = [
    {
        path: '/',
        name: 'Login',
        component: () => import('./../components/pages/auth/Login.vue'),
        meta: {guest: true}
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('./../components/pages/auth/Register.vue'),
        meta: {requiresAuth: true}
    },
    {
        path: '/home',
        name: 'Home',
        component: () => import("../components/pages/dashboard/Home.vue"),
        meta: {requiresAuth: true}
    },
    {
        path: '/tasks',
        name: 'Task',
        component: () => import('./../components/pages/dashboard/Task.vue'),
        meta: {requiresAuth: true}
    },
    {
        path: '/task-inbox',
        name: 'TaskReception',
        component: () => import("../components/pages/dashboard/TaskReception.vue"),
        meta: {requiresAuth: true}
    },
    {
        path: '/profil',
        name: 'Profil',
        component: () => import("../components/pages/dashboard/Profil.vue"),
        meta: {requiresAuth: true}
    },
    {
        path: '/task-create',
        name: 'TaskCreate',
        component: () => import("../components/pages/dashboard/TaskCreate.vue"),
        meta: {requiresAuth: true}
    },
    {
        path: '/sprint/:id?',
        name: 'Sprint',
        component: () => import("../components/pages/dashboard/Sprint.vue"),
        meta: {
            reload: true,
            requiresAuth: true
        }
    },
    {
        path: '/trash',
        name: 'Trash',
        component: () => import("../components/pages/dashboard/Trash.vue"),
        meta: {requiresAuth: true}
    },
    {
        path: '/task-show/:origin_id/:type/:task_id',
        name: 'TaskShow',
        component: () => import("../components/pages/dashboard/TaskShow.vue"),
        meta: {requiresAuth: true}
    },
    {
        path: '/projects',
        name: 'Project',
        component: () => import("../components/pages/dashboard/Project.vue"),
        meta: {requiresAuth: true}
    },
    {
        path: '/dashboard/team-insight',
        name: 'TeamInsight',
        component: () => import("../components/pages/dashboard/TeamInsight.view.vue"),
        meta: {requiresAuth: true}
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
