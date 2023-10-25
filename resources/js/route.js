import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/vue',
            component: () => import('./pages/Index.vue')
        },
        {
            path: '/vue/cart',
            component: () => import('./pages/Cart.vue')
        },
        {
            path: '/vue/payed',
            component: () => import('./pages/Payed.vue')
        },
        {
            path: '/vue/product',
            component: () => import('./pages/Product.vue')
        },
        {
            path: '/vue/user',
            component: () => import('./pages/User.vue')
        },
    ],
})

export default router;