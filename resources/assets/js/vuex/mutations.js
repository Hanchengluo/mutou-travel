export default {
    LOGIN: (state, token) => {
        state.refresh_token = token.refresh_token
        state.token = token.access_token
    },
    COLLAPSED: (state, val) => {
        state.sidebarCollapsed = val
    },
    USER_INFO: (state, user) => {
        state.user = user
    },
    NAVIGATIONS: (state, nav) => {
        state.navigations = nav
    },
    ALL_NAVIGATIONS: (state, nav) => {
        state.all_navigations = nav
    },
}
