<template>
    <div id="Dashboard" v-if="is_login_page">
        <router-view></router-view>
    </div>
    <div id="Dashboard" v-else>
        <div class="main-sidebar-wrapper">
            <div class="sidebar-wrapper" v-bind:class="{ 'sidebar-collapsed': collapsed }">
                <div class="sidebar">
                    <div class="logo-wrapper">
                        <router-link :to="{ name: 'home'}">
                            <img src="../../images/logo.png">
                        </router-link>
                    </div>
                    <div class="sidebar-nav-lists">
                        <ul class="sidebar-nav-list">
                            <li class="item">
                                <router-link :to="{ name: 'home'}">
                                    <navicon icon="home.svg" type="1"></navicon>
                                    <span class="label">控制面板</span>
                                </router-link>
                            </li>
                            <li class="item">
                                <router-link :to="{ name: 'account'}">
                                    <navicon icon="account.svg" type="1"></navicon>
                                    <span class="label">个人中心</span>
                                </router-link>
                            </li>
                            <li class="item">
                                <router-link :to="{ name: 'login'}">
                                    <navicon icon="finance.svg" type="1"></navicon>
                                    <span class="label">财务中心</span>
                                </router-link>
                            </li>
                        </ul>
                        <div class="sidebar-nav-list-divider">
                            <div class="divider"></div>
                        </div>
                        <div class="sidebar-nav-list scroller">
                            <div>
                                <li class="item" v-for="nav in navigations" v-if="nav.display == 1 && (nav.name != 'dashboard-home' && nav.name != 'account')">
                                    <router-link :to="{ name: nav.name}">
                                        <navicon :icon="nav.icon" :type="nav.icon_type"></navicon>
                                        <span class="label">{{nav.display_name}}</span>
                                        <img src="../../images/next.svg" class="sidebar-item-has-more" v-if="nav.child.length > 0">
                                    </router-link>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="copyright">
                        &copy; 2017
                        <a target="_blank" href="http://mutou.io">mutou.io</a> all rights reserved.
                    </div>
                </div>
            </div>
        </div>

        <div class="main-wrapper">
            <div class="main-navbar">
                <Button type="text" class="collapsed" @click="collapsed = !collapsed">
                    <Icon type="navicon"></Icon>
                </Button>
                <ul class="navbar">
                    <li>
                        <router-link :to="{ name: 'login'}">
                            <Icon type="ios-analytics"></Icon>
                            <span class="text">数据统计</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'login'}">
                            <Icon type="ios-calendar-outline"></Icon>
                            <span class="text">我的工单</span>
                        </router-link>
                    </li>
                    <li class="notice">
                        <Dropdown trigger="click">
                            <router-link :to="{}">
                                <Icon type="ios-bell-outline"></Icon>
                                <span class="text">消息</span>
                            </router-link>

                            <Dropdown-menu slot="list">
                                <div class="arrow"></div>
                                <div class="panel">
                                    <div class="head">
                                        <span>消息</span>
                                        <router-link :to="{}">
                                            <Icon type="ios-gear-outline"></Icon>
                                        </router-link>
                                        <router-link :to="{}" class="all-read">
                                            全部标记为已读
                                        </router-link>
                                    </div>
                                    <div class="message">
                                        <div class="empty">
                                            <Icon type="ios-filing-outline"></Icon>
                                            <span>没有消息</span>
                                        </div>
                                        <div class="message-list" v-if="false">
                                            <router-link :to="{}">
                                                <h2>消息标题</h2>
                                                <div class="body">
                                                    消息内容
                                                </div>
                                            </router-link>
                                            <router-link :to="{}">
                                                <h2>消息标题</h2>
                                                <div class="body">
                                                    消息内容
                                                </div>
                                            </router-link>
                                        </div>
                                    </div>
                                    <div class="all">
                                        <router-link :to="{}">
                                            查看全部消息
                                        </router-link>
                                    </div>
                                </div>
                            </Dropdown-menu>
                        </Dropdown>
                    </li>
                    <li>
                        <router-link :to="{ name: 'login'}">
                            <Icon type="ios-help-outline"></Icon>
                            <span class="text">文档中心</span>
                        </router-link>
                    </li>
                    <li class="account">
                        <Dropdown trigger="click" placement="bottom-end">
                            <router-link :to="{}">
                                <span class="text">个人中心</span>
                                <img :src="user.avatar | avatar('avatar.64')">
                            </router-link>
                            <Dropdown-menu slot="list">
                                <div class="panel">
                                    <div class="arrow"></div>
                                    <div class="user-info">
                                        <div class="avatar">
                                            <img :src="user.avatar | avatar('avatar.64')">
                                        </div>
                                        <div class="info">
                                            <h2>{{user.email || user.phone}}</h2>
                                            <p>{{user.name}}，{{hello}}</p>
                                        </div>
                                        <router-link :to="{name:'account'}" class="account">
                                            <Button type="primary" size="large">个人中心</Button>
                                        </router-link>
                                    </div>
                                    <div class="menu">
                                        <Row>
                                            <Col span="6">
                                            <router-link :to="{name:'account'}">
                                                <Icon type="ios-albums-outline"></Icon>
                                                <span>财务中心</span>
                                            </router-link>
                                            </Col>
                                            <Col span="6">
                                            <router-link :to="{name:'account'}">
                                                <Icon type="ios-albums-outline"></Icon>
                                                <span>财务中心</span>
                                            </router-link>
                                            </Col>
                                            <Col span="6">
                                            <router-link :to="{name:'account'}">
                                                <Icon type="ios-albums-outline"></Icon>
                                                <span>财务中心</span>
                                            </router-link>
                                            </Col>
                                            <Col span="6">
                                            <router-link :to="{name:'account'}">
                                                <Icon type="ios-albums-outline"></Icon>
                                                <span>财务中心</span>
                                            </router-link>
                                            </Col>
                                            <Col span="6">
                                            <router-link :to="{name:'account'}">
                                                <Icon type="ios-more-outline"></Icon>
                                                <span>添加常用功能</span>
                                            </router-link>
                                            </Col>
                                        </Row>
                                    </div>
                                    <div class="action">
                                        <a @click="locked">
                                            <Icon type="locked"></Icon> &nbsp;&nbsp;锁屏
                                        </a>
                                        <a @click="logout">
                                            <Icon type="power"></Icon> &nbsp;&nbsp;注销当前账号
                                        </a>
                                    </div>
                                </div>
                            </Dropdown-menu>
                        </Dropdown>
                    </li>
                </ul>
            </div>
            <div class="main-body">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import navicon from '../components/Navicon.vue'
export default {
    data: () => ({

    }),
    components:{
        navicon
    },
    methods:{
        locked:function(){
            this.$store.dispatch('locked')
        },
        logout:function(){
            this.$store.dispatch('logout')
        }
    },
    computed: {
        is_login_page: function () {
            return (this.$route.name == 'login' || this.$route.name == 'locked') ? true : false;
        },
        collapsed: {
            get: function () {
                return this.$store.state.sidebarCollapsed
            },
            set: function (val) {
                this.$store.dispatch('collapsed', val)
            }
        },
        user: function () {
            return this.$store.state.user
        },
        hello: function () {
            var now = new Date()
            var hour = now.getHours()
            if (hour < 6) {
                return '凌晨好'
            } else if (hour < 9) {
                return '早上好'
            } else if (hour < 12) {
                return '上午好'
            } else if (hour < 14) {
                return '中午好'
            } else if (hour < 17) {
                return '下午好'
            } else if (hour < 19) {
                return '傍晚好'
            } else if (hour < 22) {
                return '晚上好'
            }
        },
        navigations:function(){
            return this.$store.state.navigations
        }
    },
    created: function () {
        // 初始化数据
        if (!this.is_login_page && this.$store.state.token == '') {
            this.$store.dispatch('init')
        }
        window.$Message = this.$Message
    },
    updated: function () {
        // 初始化数据
        if (!this.is_login_page && this.$store.state.user.name == '' && this.$store.state.user.phone == '' && this.$store.state.user.email == '') {
            this.$store.dispatch('init')
        }

        /**
         * 刷新 access_token
         *
         * 过期10分钟前刷新access_token
         */
        var token_expires = Number(window.localStorage.getItem('token_expires')) || 0
        var differ = token_expires - Number(window.$.now())
        if (differ < 600000 && !this.is_login_page) {
            this.$store.dispatch('refresh_token')
        }
    }

}
</script>

<style lang="scss" scoped>
div.main-sidebar-wrapper {
    -ms-flex-negative: 0;
    flex-shrink: 0;
    height: inherit;
    div.sidebar-wrapper {
        position: relative;
        height: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        .sidebar {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 230px;
            background-color: #f5f7fa;
            border-right: 1px solid #e6e9f0;
            -webkit-transition: all .15s;
            transition: all .15s;
            position: relative;
            height: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            div.logo-wrapper {
                line-height: 90px;
                text-align: center;
                img {
                    width: 45px;
                    vertical-align: middle;
                    tranistion: all .15s;
                }
            }
            div.sidebar-nav-lists {
                overflow: hidden;
                -webkit-box-flex: 1;
                -ms-flex-positive: 1;
                flex-grow: 1;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                .scroller {
                    position: relative;
                    overflow: hidden !important;
                    overflow-y: auto !important;
                }
                .sidebar-nav-list {
                    padding: 0;
                    margin-bottom: 0;
                    list-style: none;
                    .item {
                        list-style: none;
                        a {
                            display: block;
                            height: 45px;
                            padding: 0 27px;
                            margin: 0 0 5px;
                            line-height: 45px;
                            color: #8d9199;
                            border-left: 3px solid transparent;
                            border-right: 3px solid transparent;
                            font-size: 14px;
                            white-space: nowrap;
                            &:hover {
                                background-color: #e1edfa;
                            }
                            &.active {
                                color: #2f3033;
                                border-left-color: #008afe;
                                background-color: #e1edfa;
                            }
                            .label {
                                vertical-align: middle;
                            }
                            .icon {
                                width: 20px;
                                height: 20px;
                                line-height: 20px;
                                text-align: center;
                                font-size: 24px;
                                margin-right: 14px;
                                vertical-align: middle;
                                color: #ced0d6;
                            }
                        }
                    }
                }
            }
            .sidebar-nav-list-divider {
                margin: 20px 0;
                height: 1px;
                .divider {
                    margin: 0 auto;
                    height: 1px;
                    width: 180px;
                    background-color: #e6e9f0;
                }
            }

            .sidebar-item-has-more {
                position: absolute;
                right: 27px;
                padding: 12.5px 0;
            }
            .copyright {
                height: 20px;
                line-height: 20px;
                font-size: 12px;
                color: #ccc;
                text-align: center;
                a {
                    color: #ccc;
                }
            }
        }
        &.sidebar-collapsed {
            .sidebar {
                width: 80px;
            }
            span.label {
                display: none;
            }
            .sidebar-item-has-more {
                display: none;
            }
            .sidebar-nav-list-divider .divider {
                width: 30px;
            }
            .copyright {
                display: none;
            }
        }
    }
}

div.main-wrapper {
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    overflow: hidden;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    div.main-navbar {
        height: 60px;
        -ms-flex-preferred-size: 60px;
        flex-basis: 60px;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        border-bottom: 1px solid #e6e9f0;
        background-color: #fff;
        border-color: #e6e9f0;
        padding: 0px 10px;
        &:before {
            content: " ";
            display: table;
        }
        &:after {
            content: " ";
            display: table;
            clear: both;
        }
        .collapsed {
            color: #8d9199;
            font-size: 32px;
        }
        ul.navbar {
            &:before {
                content: " ";
                display: table;
            }
            &:after {
                content: " ";
                display: table;
                clear: both;
            }
            float: right;
            li {
                list-style: none;
                float: left;
                a {
                    display: inline-block;
                    padding: 16px 14px;
                    padding-right: 5px;
                    line-height: 28px;
                    font-size: 14px;
                    color: #7a8599;
                    i {
                        font-size: 18px;
                        display: block;
                        float: left;
                        padding-top: 5px;
                    }
                    i.ivu-icon-ios-analytics {
                        font-size: 16px;
                    }
                    span.text {
                        padding-left: 5px;
                    }
                    &:hover {
                        color: #333;
                    }
                }
                &.account {
                    img {
                        width: 30px;
                        height: 30px;
                        border-radius: 50%;
                        float: right;
                        margin-top: -3px;
                        margin-left: 10px;
                    }
                    span.text {
                        padding-left: 16px;
                        border-left: 1px solid #eee;
                    }

                    div.arrow {
                        width: 16px;
                        height: 16px;
                        transform: rotate(45deg);
                        position: relative;
                        top: -14px;
                        left: 400px;
                        z-index: -1;
                        background-color: #fff;
                        border-left: 1px solid #eee;
                        border-top: 1px solid #eee;
                    }

                    div.panel {
                        width: 480px;
                        height: auto;
                        div.user-info {
                            margin-top: -20px;
                            padding: 18px 30px;
                            border-bottom: 1px solid #eee;
                            &:before {
                                content: " ";
                                display: table;
                            }
                            &:after {
                                content: " ";
                                display: table;
                                clear: both;
                            }
                            div.avatar {
                                width: 64px;
                                height: 64px;
                                border-radius: 50%;
                                overflow: hidden;
                                float: left;
                                margin-right: 10px;
                                img {
                                    width: 64px;
                                    height: 64px;
                                }
                            }
                            div.info {
                                width: auto;
                                height: 64px;
                                float: left;
                                max-width: 240px;
                                overflow: hidden;
                                h2 {
                                    padding: 0;
                                    margin: 0;
                                    line-height: 30px;
                                }
                                p {
                                    line-height: 24px;
                                }
                            }
                            a.account {
                                float: right;
                                padding: 14px 0px;
                            }
                        }
                        div.menu {
                            padding: 22px 30px;
                            div.ivu-row {
                                div.ivu-col {
                                    a {
                                        display: block;
                                        width: 100%;
                                        padding: 18px 0 23px;
                                        text-align: center;
                                        i.ivu-icon {
                                            margin: 0 0 15px;
                                            display: block;
                                            width: 100%;
                                            font-size: 18px;
                                        }
                                        span {
                                            display: block;
                                        }
                                        &:hover {
                                            color: #1989fa;
                                        }
                                        &.active {
                                            color: #1989fa;
                                        }
                                    }
                                }
                            }
                        }

                        div.action {
                            width: 100%;
                            height: 50px;
                            border-top: solid 1px #eee;
                            a {
                                display: block;
                                width: 50%;
                                height: 50px;
                                line-height: 50px;
                                float: left;
                                padding: 0;
                                text-align: center;
                                &:first-child {
                                    border-right: .5px solid #eee;
                                    width: calc(50% -1px);
                                }
                                i {
                                    float: none;
                                    display: inline-block;
                                    padding: 0;
                                    font-size: 14px;
                                }
                            }
                        }
                    }
                }
                &.notice {
                    div.panel {
                        width: 260px;
                        margin-top: -22px;
                        div.head {
                            padding: 15px 20px;
                            line-height: 22px;
                            background-color: #f5f7fa;
                            border-bottom: 1px solid #dcdfe5;
                            a {
                                padding: 0;
                                display: block;
                                float: right;
                                color: #8d9199;
                                font-size: 18px;
                            }
                            a.all-read {
                                font-size: 12px;
                                padding-right: 10px;
                            }
                            &:before {
                                content: " ";
                                display: table;
                            }
                            &:after {
                                content: " ";
                                display: table;
                                clear: both;
                            }
                        }
                        div.message {
                            width: 100%;
                            height: auto;
                            max-height: 240px;
                            overflow-y: auto;
                            div.empty {
                                width: inherit;
                                height: auto;
                                color: #aaa;
                                margin-bottom: 10px;
                                i.ivu-icon {
                                    display: block;
                                    width: 100%;
                                    height: auto;
                                    text-align: center;
                                    font-size: 64px;
                                }
                                span {
                                    display: block;
                                    text-align: center;
                                }
                            }
                            div.message-list {
                                a {
                                    display: block;
                                    width: 100%;
                                    height: auto;
                                    padding: 10px;
                                    border-top: solid 1px #eee;
                                    &::first-child {
                                        border: none
                                    }
                                    h2 {
                                        font-size: 14px;
                                        font-weight: normal
                                    }
                                    div.body {
                                        font-size: 12px;
                                    }
                                }
                            }
                        }
                        div.all {
                            margin-top: 10px;
                            border-top: solid 1px #eee;
                            margin-bottom: -5px;
                            a {
                                display: block;
                                width: 100%;
                                height: 40px;
                                line-height: 40px;
                                text-align: center;
                                padding: 0;
                                font-size: 12px;
                            }
                        }
                    }
                    div.arrow {
                        width: 16px;
                        height: 16px;
                        transform: rotate(45deg);
                        position: relative;
                        top: -14px;
                        left: 120px;
                        z-index: -1;
                        background-color: #f5f7fa;
                        border-left: 1px solid #eee;
                        border-top: 1px solid #eee;
                    }
                }
            }
        }
    }
    div.main-body {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        position: relative;
        height: 100%;
        overflow: auto;
    }
}

@media screen and (max-width: 1020px) {
    div.main-wrapper {
        ul.navbar {
            li {
                a {
                    span.text {
                        display: none;
                    }
                }
                &.account {
                    div.arrow {
                        left: 453px!important;
                    }
                }
            }
        }
    }
}





/* 垂直滚动条的滑动块 */

 ::-webkit-scrollbar-thumb:vertical {
    border-radius: 4px;
    background-color: rgba(#aaa, 0.3);
}

.sidebar,
.sidebar-wrapper {
    position: relative;
    height: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
     ::-webkit-scrollbar {
        width: 6px;
        display: block;
    }
    &:hover {
         ::-webkit-scrollbar {
            width: 6px;
            display: block;
        }
    }
}
</style>
