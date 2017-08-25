import Vue from 'vue'
import router from '../routers'
import axios from 'axios'
import store from '../vuex'
import iView from 'iview'
Vue.use(iView);

axios.defaults.baseURL = '/api/dashboard';

axios.interceptors.request.use(
    config => {
        if (store.state.token) {
            config.headers.Authorization = `Bearer ${store.state.token}`;
        }
        return config;
    },
    err => {
        return Promise.reject(err);
    });

axios.interceptors.response.use(config => { 
    return config
}, err => { 

    return Promise.reject(error)
})

export default {
    // 用户登录
    login: ({
        commit
    }, user) => {
        var data = {
            'username': user.username,
            'password': user.password
        }
        axios.post('/login', data).then((res) => {
            window.localStorage.setItem('access_token', res.data.access_token)
            window.localStorage.setItem('refresh_token', res.data.refresh_token)
            window.localStorage.setItem('token_expires', Number(window.$.now()) + (Number(res.data.expires_in) *
                1000))
            window.localStorage.setItem('refresh_token_expires', Number(window.$.now()) + 2592000000)
            window.localStorage.setItem('user', JSON.stringify(res.data.user))

            commit('LOGIN', res.data)
            user.obj.$Message.destroy()
            router.push('/dashboard/home')
        }).catch((err) => {
            user.obj.$Message.destroy()
            user.obj.$Message.error(err.response.data.message)
        })

    },
    // 用户登出
    logout: ({
        commit
    }) => {
        window.localStorage.removeItem('access_token')
        window.localStorage.removeItem('refresh_token')
        window.localStorage.removeItem('token_expires')
        window.localStorage.removeItem('refresh_token_expires')
        window.localStorage.removeItem('user');
        router.push('/dashboard/login')
    },
    // 锁定屏幕
    locked:({commit})=>{
        window.localStorage.removeItem('access_token')
        window.localStorage.removeItem('token_expires')
        router.push('/dashboard/locked')
    },
    // 初始化数据
    init: ({
        commit,
        dispatch
    }) => {
        var access_token = window.localStorage.getItem('access_token') || ''
        var refresh_token = window.localStorage.getItem('refresh_token') || ''
        var token = {
            'access_token': access_token,
            'refresh_token': refresh_token
        }
        commit('LOGIN', token)

        axios.get('init').then((res) => {
            console.log(res);
            commit('USER_INFO', res.data.user)
            commit('NAVIGATIONS', res.data.nav)
        }).catch((err) => {
            dispatch('logout')
        })
    },
    // 解锁 刷新access_token
    unLocked: ({
        commit,
        dispatch
    }, user) => {
        var refresh_token = window.localStorage.getItem('refresh_token');
        if (!refresh_token || refresh_token == '') {
            dispatch('logout')
        }
        var data = {
            id: user.id,
            password: user.password,
            refresh_token: refresh_token
        }

        axios.post('unlock', data).then((res) => {
            window.localStorage.setItem('access_token', res.data.access_token)
            window.localStorage.setItem('refresh_token', res.data.refresh_token)
            window.localStorage.setItem('token_expires', Number(window.$.now()) + (Number(res.data.expires_in) *
                1000))
            window.localStorage.setItem('refresh_token_expires', Number(window.$.now()) + 2592000000)
            commit('LOGIN', res.data)
            router.push('/dashboard/home')
        }).catch((err) => {
            if (err.response.status == 500) {
                dispatch('logout')
            } else {
                user.obj.$Message.error(err.response.data.message)
            }
        })


    },
    // 刷新令牌
    refresh_token: ({
        commit,
        dispatch
    }) => {
        var refresh_token = window.localStorage.getItem('refresh_token');
        axios.post('refresh', {
            refresh_token: refresh_token
        }).then((res) => {
            window.localStorage.setItem('access_token', res.data.access_token)
            window.localStorage.setItem('refresh_token', res.data.refresh_token)
            window.localStorage.setItem('token_expires', Number(window.$.now()) + (Number(res.data.expires_in) *
                1000))
            window.localStorage.setItem('refresh_token_expires', Number(window.$.now()) + 2592000000)
            commit('LOGIN', res.data)
        }).catch((err) => {
            dispatch('logout')
        })
    },

    // 侧边导航开合
    collapsed: ({
        commit
    }, val) => {
        commit('COLLAPSED', val)
    }
}
