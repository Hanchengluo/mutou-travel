<template>
    <div id="navigations" class="root-element">
        <breadcrumb>
            <div slot="left">
                <Button type="success" @click="to_add">新增导航</Button>
                <Button @click="get_navigations" :loading="loading">
                    <Icon type="refresh" v-show="!loading"></Icon>
                </Button>
            </div>
            <div slot="right">
                <Button>网址重定向</Button>
            </div>
        </breadcrumb>
        <div class="layout-content">
            <div class="nav-lists">
                <Row :gutter="32">
                    <Col span="12" v-for="nav in all_navigations" :key="nav.id">
                    <div class="navigation-list-item">
                        <div class="header">
                            <strong>{{nav.display_name}}</strong>
                            <span> [ {{nav.name}} ]</span>
                        </div>
                        <div class="navs">
                            <span v-for="item in nav.nav" :key="item.id">{{item.display_name}}</span>
                        </div>
                        <div class="btn">
                            <Button @click="to_edit(nav)">编辑</Button>
                        </div>
                    </div>
                    </Col>
                </Row>
                <Spin size="large" fix v-if="loading"></Spin>
            </div>
        </div>
    </div>
</template>
<script>
import breadcrumb from '../../components/Breadcrumb.vue'
export default {
    data: () => ({
        loading: false
    }),
    methods: {
        to_add: function() {
            this.$router.push({ name: 'navigations-add' })
        },
        to_edit:function(nav){
            console.log(nav)
            this.$router.push({name:'navigations-edit',params:{nav:nav,id:nav.id}});
        },
        get_navigations: function() {
            this.loading = true
            this.$store.dispatch('get_all_navigations')
        }
    },
    components: {
        breadcrumb
    },
    computed: {
        all_navigations: function() {
            return this.$store.state.all_navigations
        }
    },
    created() {
        const _this = this
        axios.interceptors.response.use(function(response) {
            _this.loading = false
            return response;
        }, function(error) {
            _this.loading = false
            return Promise.reject(error);
        });
        this.get_navigations()
    }
}
</script>
<style lang="scss" scoped>
.nav-lists {
    padding: 20px;
    .navigation-list-item {
        width: 100%;
        height: auto;
        min-height: 140px;
        border: 1px solid #bcd;
        // position: absolute;
        padding-top: 10px;
        div.header {
            display: inline-block;
            width: auto;
            height: 30px;
            line-height: 30px;
            padding: 0px 10px;
            background-color: #49d;
            color: #fff;
            font-size: 14px;
            position: relative;
            left: -6px;
            top: 0px;
            strong {
                font-weight: normal;
            }
            &::after{
                display: block;
                content: '';
                width: 0;
                height: 0;
                border-right: 4px solid transparent;
                border-bottom: 4px solid #49d;
                border-left: 4px solid transparent;
                transform: rotate(45deg);
                position: relative;
                left: -10px;
                top: -1.5px;
            }
        }
        div.navs{
            width: 100%;
            height: 50px;
            line-height: 50px;
            padding: 0px 20px;
            span{
                font-size: 14px;
                color: #555;
                padding: 0 5px 0 0;
                &::after{
                    display: inline-block;
                    content: '/';
                    padding-left: 5px;
                    color: #ccc;
                }
                &:last-child::after{
                    display: inline-block;
                    content: '';
                    padding-left: 5px;
                    color: #ccc;
                }
            }
        }
        div.btn{
            width: 100%;
            height: 50px;
            line-height: 50px;
            background-color: #f2f7fb;
            border-top: 1px solid #bcd;
            padding: 0px 20px;
        }
    }
}
</style>

