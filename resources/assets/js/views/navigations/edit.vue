<template>
    <div id="navigations-add">
        <breadcrumb>
            <div slot="left">
                <Button @click="go_back">
                    <Icon type="ios-arrow-left"></Icon> 返回
                </Button>
                <Button type="success">确认保存</Button>
            </div>
            <div slot="right">
                <Button type="error" disabled>删除</Button>
            </div>
        </breadcrumb>
        <div class="layout-content">
            <Form label-position="top" :model="navigation">
                <FormItem label="导航名称">
                    <Input placeholder="请输入导航名称" v-model="navigation.display_name"></Input>
                </FormItem>
                <FormItem label="导航标识">
                    <span slot="label">导航标识
                        <Tooltip content="英文字母，新增后一般不允许修改" placement="right">
                            <Icon type="ios-information"></Icon>
                        </Tooltip>
                    </span>
                    <Input placeholder="请输入导航标识" v-model="navigation.name"></Input>
                </FormItem>
                <FormItem label="导航排序" class="sort">
                    <span slot="label">导航排序
                        <Tooltip content="越小越靠前" placement="right">
                            <Icon type="ios-information"></Icon>
                        </Tooltip>
                    </span>
                    <Slider v-model="navigation.sort"></Slider>
                </FormItem>
                <FormItem label="导航项目设置" class="nav">
                    <span slot="label">导航项目设置
                        <i>(可添加子级菜单，最多三级菜单，拖动
                            <Icon type="android-more-vertical"></Icon> 可调整同级下菜单项目的位置)</i>
                    </span>
                    <Row class="nav-row">
                        <Col span="14" class="navigation-edit">
                        <div class="navigation-edit-title">一级菜单</div>
                        <div class="navigation-edit-lists">
                            <div class="navigation-edit-lists-header">
                                <div class="item">显示名称</div>
                                <div class="item">标识字符</div>
                                <div class="item">链接地址</div>
                                <div class="item">导航图标</div>
                                <div class="item">是否显示</div>
                                <div class="item">跳转方式</div>
                            </div>
                            <div class="navigation-edit-lists-items">
                                <div class="navigation-edit-lists-items-row" v-for="(nav, index) in navigation.nav" :key="index" :prop="'nav.' + index" v-on:mouseenter="">
                                    <div class="item name">
                                        <Icon type="android-more-vertical"></Icon>
                                        <Input placeholder="显示名称" v-model="nav.display_name"></Input>
                                    </div>
                                    <div class="item">
                                        <Input placeholder="英文标识" v-model="nav.name"></Input>
                                    </div>
                                    <div class="item link">
                                        <Input placeholder="链接地址" v-model="nav.url">
                                        <Button slot="append" icon="ios-box"></Button>
                                        </Input>
                                    </div>
                                    <div class="item">
                                        <navicon icon="ios-grid-view-outline" type="0"></navicon>&nbsp;&nbsp;
                                        <Button icon="ios-camera"></Button>
                                    </div>
                                    <div class="item">
                                        <i-switch size="large" v-model="nav.display">
                                            <span slot="open">显示</span>
                                            <span slot="close">隐藏</span>
                                        </i-switch>
                                    </div>
                                    <div class="item">
                                        <Select v-model="nav.target">
                                            <Option value="_blank">
                                                新窗口打开
                                            </Option>
                                            <Option value="_self">
                                                原窗口打开
                                            </Option>
                                        </Select>
                                        <Button type="error">
                                            <Icon type="trash-a"></Icon>
                                        </Button>
                                    </div>
                                </div>
                                <div class="add-button">
                                    <Button>新增一项</Button>
                                </div>
                            </div>
                        </div>
                        </Col>
                        <Col span="5" class="navigation-edit">
                        <div class="navigation-edit-title">二级菜单</div>
                        <div class="navigation-show-list">
                            <div class="navigation-show-list-row">

                            </div>
                            <div class="add-sub-nav">
                                <Button type="success" long>添加子菜单</Button>
                            </div>
                        </div>
                        </Col>
                        <Col span="5" class="navigation-edit">
                        <div class="navigation-edit-title">三级菜单</div>
                        </Col>
                    </Row>
                </FormItem>
            </Form>

            <div class="save-bottom">
                <Button type="success">确认保存</Button>
            </div>
        </div>
    </div>
</template>
<script>
import breadcrumb from '../../components/Breadcrumb.vue'
import navicon from '../../components/Navicon.vue'
export default {
    data: () => ({
        navigation: {
            name: '',
            display_name: '',
            sort: 0,
            nav: [{
                name: '',
                display_name: '',
                display: true,
                parent_id: 0,
                sort: 0,
                target: '_self',
                url: '',
                icon: 'ios-grid-view-outline',
                icon_type: 0,
                child:[]
            }]
        },
        
    }),
    components: {
        breadcrumb,
        navicon
    },
    methods: {
        go_back: function() {
            this.$router.go(-1)
        }
    },
    created() {
        if (this.$route.name == 'navigations-edit') {
            this.navigation = this.$route.params.nav
        }
        console.log(this.$route)
    }
}
</script>
<style lang="scss" scoped>
#navigations-add {
    .layout-content {
        .ivu-form {
            padding: 40px 30px;
            .ivu-form-item {
                .ivu-form-item-label {
                    font-size: 14px!important;
                }
                &.nav {
                    .ivu-form-item-label {
                        span {
                            i {
                                font-style: normal;
                                font-size: 12px;
                                color: #888;
                                i.ivu-icon {
                                    width: 10px;
                                    text-align: center;
                                    color: #57a3f3;
                                    border: #57a3f3 solid .5px;
                                }
                            }
                        }
                    }
                }
            }
        }

        div.nav-row {
            width: 100%;
            height: auto;
            .navigation-edit {
                .navigation-edit-title {
                    width: 100%;
                    height: 40px;
                    line-height: 40px;
                    text-align: center;
                    border: solid 1px #3288df;
                    background-color: #49d;
                    color: #fff;
                    margin-bottom: 20px;
                    border-right: dashed 1px #fff;
                }
                &:last-child {
                    .navigation-edit-title {
                        border-right: solid 1px #3288df;
                    }
                }
                .navigation-edit-lists {
                    width: 100%;
                    height: auto;
                    border: solid 1px #3288df;
                    .navigation-edit-lists-header {
                        width: 100%;
                        height: 45px;
                        border-bottom: 1px solid #b4cfea;
                        background-color: #f2f7fb;
                        color: #246;
                        display: flex;
                        div.item {
                            flex: 1;
                            text-align: center;
                            line-height: 45px;
                            font-size: 14px;
                        }
                    }
                    .navigation-edit-lists-items {
                        width: 100%;
                        height: auto;
                        .navigation-edit-lists-items-row {
                            height: 50px;
                            line-height: 50px;
                            border-bottom: solid 1px #b4cfea;
                            display: flex;
                            i.ivu-icon {
                                font-size: 14px!important;
                            }
                            div.item {
                                flex: 1;
                                text-align: center;
                                line-height: 45px;
                                padding: 0px 5px;
                                .ivu-select {
                                    width: 60%;
                                }
                                &.name {
                                    i.ivu-icon {
                                        font-size: 14px;
                                        width: 20px;
                                        text-align: center;
                                        color: #57a3f3;
                                        cursor: pointer;
                                    }
                                    .ivu-input-wrapper {
                                        width: 80%;
                                    }
                                }
                                &.link {
                                    .ivu-input-wrapper {
                                        margin-top: 5px;
                                    }
                                }
                            }
                        }
                        div.add-button {
                            width: 100%;
                            height: 60px;
                            padding: 20px;
                        }
                    }
                }
                &:last-child {
                    .navigation-edit-title {
                        border-right: solid 1px #3288df;
                    }
                }
                .navigation-show-list {
                    width: calc(100% - 10px);
                    height: auto;
                    border: solid 1px #3288df;
                    margin-left: 10px;
                    .navigation-show-list-row {
                        height: 50px;
                        line-height: 50px;
                        border-bottom: solid 1px #b4cfea;
                    }
                    .add-sub-nav{
                        padding: 20px;
                    }
                }
            }
        }
        div.save-bottom {
            width: 100%;
            height: auto;
            padding: 30px;
            border-top: solid 1px #eee;
        }

        i.ivu-icon.ivu-icon-ios-information {
            color: #ffad33;
        }
    }
}
</style>
<style>
.ivu-form-item-label {
    font-size: 14px!important;
}
</style>


