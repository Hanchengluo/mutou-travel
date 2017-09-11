import Vue from 'vue';
import Vuex from 'vuex';
import actions from './actions.js';
import mutations from './mutations.js';

Vue.use(Vuex);

const state = {
    token: '',
    refresh_token: '',
    user: {
        name: '',
        phone: '',
        email: '',
        avatar: '/avatars/default.jpg'
    },
    locked: false,
    sidebarCollapsed: false,
    navigations: '',
    all_navigations:'',
    redirects:'',
};

export default new Vuex.Store({
    state,
    actions,
    mutations
});
