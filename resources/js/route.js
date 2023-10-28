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
        {
            path: '/vue/notification',
            component: () => import('./pages/Notification.vue')
        },
    ],
})

export default router;