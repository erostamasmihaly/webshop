import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/vue/product/:id',
            component: () => import('./pages/Product.vue')
        },
        {
            path: '/vue/user',
            component: () => import('./pages/User.vue')
        },
        {
            path: '/vue/list',
            component: () => import('./pages/List.vue')
        },
    ],
})

export default router;