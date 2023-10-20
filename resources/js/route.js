import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/vue',
            component: () => import('./pages/Index.vue')
        },
    ],
})

export default router;