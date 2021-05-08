import Vue from 'vue'
import VueRouter from 'vue-router' 
Vue.use(VueRouter)
Vue.component('pagination', require('laravel-vue-pagination'));

import App from './components/App'
import Home from './components/Home'
import Login from './components/Login'
import Register from './components/Register'
import SingleProduct from './components/User/SingleProduct'
import Checkout from './components/User/Checkout'
import Confirmation from './components/User/Confirmation'
import UserBoard from './components/User/UserBoard'
import Admin from './components/Admin/Admin'
import appFooter from './components/appFooter'
import userOrders from './components/Admin/userOrders'

const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/',
                name: 'home',
                component: Home
            },
            {
                path: '/login',
                name: 'login',
                component: Login
            },
            {
                path: '/register',
                name: 'register',
                component: Register
            },
            {
                path: '/products/:id',
                name: 'single-products',
                component: SingleProduct
            },
        

            {
                path: '/confirmation',
                name: 'confirmation',
                component: Confirmation
            },
            {
                path: '/checkout',
                name: 'checkout',
                component: Checkout,
                props: (route) => ({ pid: route.query.pid })
            },
            {
                path: '/dashboard',
                name: 'userboard',
                component: UserBoard,
                meta: {
                    requiresAuth: true,
                    is_user: true
                }
            },
            {
                path: '/admin/:page',
                name: 'admin-pages',
                component: Admin,
                meta: {
                    requiresAuth: true,
                    is_admin: true
                }
            },
            {
                path: '/admin',
                name: 'admin',
                component: Admin,
                meta: {
                    requiresAuth: true,
                    is_admin: true
                }
            },
            {
                path: '/admin/userOrders:id',
                name: 'userOrders' ,
                component: userOrders,
                meta: {
                    requiresAuth: true,
                    is_admin: true
                }
            }
        ],
    })

router.beforeEach((to, from, next) => {
        if (to.matched.some(record => record.meta.requiresAuth)) {
            if (localStorage.getItem('loggedUserToken.jwt') == null) {
                next({
                    path: '/login',
                    params: { nextUrl: to.fullPath }
                })
            } else {
                let user = JSON.parse(localStorage.getItem('loggedUserToken.user'))
                if (to.matched.some(record => record.meta.is_admin)) {
                    if (user.is_admin == 1) {
                        next()
                    }
                    else {
                        next({ name: 'userboard' })
                    }
                }
                else if (to.matched.some(record => record.meta.is_user)) {
                    if (user.is_admin == 0) {
                        next()
                    }
                    else {
                        next({ name: 'admin' })
                    }
                }
                next()
            }
        } else {
            next()
        }
    })

const app = new Vue({
        el: '#app',
        components: { App },
        router,
    });