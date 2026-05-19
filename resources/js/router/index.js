// resources/js/router/index.js

import {createRouter, createWebHistory} from 'vue-router'

import {useAuthStore} from '@/stores/authStore'
import {useAlertStore} from '@/stores/alertStore'

import CarCreate from '@/pages/CarCreate.vue'
import CarShow from '@/pages/CarShow.vue'
import CarsIndex from '@/pages/CarsIndex.vue'
import Cart from '@/pages/Cart.vue'
import Contact from '@/pages/Contact.vue'
import Dashboard from '@/pages/Dashboard.vue'
import Home from '@/pages/Home.vue'
import Login from '@/pages/Login.vue'
import MyOrders from '@/pages/MyOrders.vue'
import NotFound from '@/pages/NotFound.vue'
import OrderDetails from '@/pages/OrderDetails.vue'
import OrderSuccess from '@/pages/OrderSuccess.vue'
import Page from '@/pages/Page.vue'
import Profile from '@/pages/Profile.vue'
import Register from '@/pages/Register.vue'

const routes = [

    // Главная страница
    {path: '/', name: 'home', component: Home},

    // Страницы без авторизации
    {path: '/cars', name: 'cars', component: CarsIndex},
    {path: '/cars/show/:id', name: 'car-show', component: CarShow},
    {path: '/contact', name: 'contact', component: Contact},
    {path: '/login', name: 'login', component: Login, meta: {guest: true}},
    {path: '/page/:code', name: 'page', component: Page},
    {path: '/register', name: 'register', component: Register, meta: {guest: true}},

    // Страницы с авторизацией
    {path: '/cart', name: 'cart', component: Cart, meta: {requiresAuth: true}},
    {path: '/dashboard', name: 'dashboard', component: Dashboard, meta: {requiresAuth: true}},
    {path: '/dashboard/car/create', name: 'dashboard-car-create', component: CarCreate, meta: {requiresAuth: true}},
    {path: '/dashboard/profile', name: 'dashboard-profile', component: Profile, meta: {requiresAuth: true}},
    {path: '/order-success/:id', name: 'order-success', component: OrderSuccess, meta: {requiresAuth: true}},
    {path: '/orders', name: 'orders', component: MyOrders, meta: {requiresAuth: true}},
    {path: '/orders/:id', name: 'order-details', component: OrderDetails, meta: {requiresAuth: true}},

    // Ошибка 404 - страница не найдена
    {path: '/not-found', name: 'not-found', component: NotFound},
    {path: '/:pathMatch(.*)*', redirect: '/not-found'}

]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.afterEach(() => {
    const alertStore = useAlertStore()
    alertStore.clear()
})

router.beforeEach(async (to) => {
    const auth = useAuthStore()
    console.log('beforeEach')
    if (!auth.initialized) {
        await auth.initAuth()
    }
    if (to.meta.requiresAuth && !auth.user) {
        return {name: 'login'}
    }
    if (to.meta.guest && auth.user) {
        return {name: 'dashboard'}
    }
})

export default router
