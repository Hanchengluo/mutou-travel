import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from '../views/Dashboard.vue'

Vue.use(VueRouter);

const routes = new VueRouter({
    mode: 'history',
    base: __dirname,
    linkActiveClass: 'active',
    routes: [{
        path: '/dashboard',
        component: Dashboard,
        children: [{
            path: '/',
            redirect: '/dashboard/home'
        }, {
            path: 'home',
            name: 'home',
            component: require('../views/home.vue')
        }, {
            path: 'account',
            name: 'account',
            component: require('../views/account/index.vue')
        }, {
            path: 'login',
            name: 'login',
            component: require('../views/Login.vue')
        }, {
            path: 'locked',
            name: 'locked',
            component: require('../views/locked.vue')
        },{
            path:'navigations',
            name:'navigations',
            component: require('../views/navigations/index.vue')
        },{
            path:'navigations/add',
            name:'navigations-add',
            component: require('../views/navigations/edit.vue')
        },{
            path:'navigations/edit/:id',
            name:'navigations-edit',
            component: require('../views/navigations/edit.vue')
        },{
            path:'navigations/redirect',
            name:'navigations-redirect',
            component:require('../views/navigations/redirect.vue')
        },{
            path: '*',
            redirect: '/dashboard/home'
        }]
    }]
})

routes.beforeEach((to, from, next) => {
    // document.title = to.meta.title
    var refresh_token_expires = Number(window.localStorage.getItem('refresh_token_expires')) || 0
    var token_expires = Number(window.localStorage.getItem('token_expires')) || 0

    if (window.$.now() < token_expires && (to.name === 'login' || to.name === 'locked')) {
        next({
            name: 'home'
        })
    } else if (window.$.now() > token_expires && window.$.now() < refresh_token_expires && to.name != 'login' &&
        to.name != 'locked') {
        next({
            name: 'locked'
        })
    } else if (window.$.now() > refresh_token_expires && to.name != 'login') {
        next({
            name: 'login'
        })
    } else {
        next()
    }
})
export default routes
