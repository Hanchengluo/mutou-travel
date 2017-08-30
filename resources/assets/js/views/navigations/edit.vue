<template>
    <div id="navigations-add" class="root-element">
        <breadcrumb>
            <div slot="left">
                <Button @click="go_back">
                    <Icon type="ios-arrow-left"></Icon> 返回
                </Button>
                <Button type="success" @click="handleSubmit">确认保存</Button>
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
                        <Col :span="(currentEdit == 1) ? 14 : 5 " class="navigation-edit">
                        <div class="navigation-edit-title">一级菜单</div>
                        <NavigationEdit :navigations="navigation.nav" :edit="currentEdit == 1" :level="1" :act="editLevel" v-on:listenNavigationsChangeEvent="changeNavLevel1"></NavigationEdit>
                        </Col>
                        <Col :span="(currentEdit == 2) ? 14 : 5 " class="navigation-edit">
                        <div class="navigation-edit-title">二级菜单</div>
                        <NavigationEdit :navigations="level_2_nav" :edit="currentEdit == 2" :level="2" :act="editLevel" v-on:listenNavigationsChangeEvent="changeNavLevel2"></NavigationEdit>
                        </Col>
                        <Col :span="(currentEdit == 3) ? 14 : 5 " class="navigation-edit">
                        <div class="navigation-edit-title">三级菜单</div>
                        <NavigationEdit :navigations="level_3_nav" :edit="currentEdit == 3" :level="3" :act="editLevel" v-on:listenNavigationsChangeEvent="changeNavLevel3" v-if="is_show_level_3"></NavigationEdit>
                        </Col>
                    </Row>
                </FormItem>
            </Form>

            <div class="save-bottom">
                <Button type="success" @click="handleSubmit">确认保存</Button>
            </div>
        </div>
    </div>
</template>
<script>
import breadcrumb from '../../components/Breadcrumb.vue'
import navicon from '../../components/Navicon.vue'
import NavigationEdit from '../../components/NavigationEdit.vue'
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
                child: []
            }]
        },
        level_1_index: 0,
        level_2_index: 0,
        level_3_index: 0,
        currentEdit: 1,

    }),
    components: {
        breadcrumb,
        navicon,
        NavigationEdit
    },
    methods: {
        // 返回
        go_back: function() {
            this.$router.go(-1)
        },

        changeNavLevel1: function(data) {
            this.navigation.nav = data.navigations
            this.level_1_index = data.currentIndex
        },
        changeNavLevel2: function(data) {
            try {
                if (typeof (this.navigation.nav[this.level_1_index]) != undefined) {
                    this.navigation.nav[this.level_1_index].child = data.navigations
                    this.level_2_index = data.currentIndex
                }
            } catch (error) {

            }
        },
        changeNavLevel3: function(data) {
            try {
                if (typeof (this.navigation.nav[this.level_1_index]) != undefined) {
                    this.navigation.nav[this.level_1_index].child[this.level_2_index].child = data.navigations
                    this.level_3_index = data.currentIndex
                }
            } catch (error) {

            }
        },
        editLevel:function(current){
            this.currentEdit = current
        },
        handleSubmit:function(){
            this.$store.dispatch('add_navigations',this.navigation)
        }
    },
    computed: {
        level_2_nav: function() {
            // const navs = this.navigation.nav[this.level_1_index].child;
            try {
                const navs = this.navigation.nav[this.level_1_index].child;
                return navs
            } catch (error) {
                return []
            }
        },
        level_3_nav:function(){
            try {
                const navs = this.navigation.nav[this.level_1_index].child[this.level_2_index].child;
                return navs
            } catch (error) {
                return []
            }
        },
        is_show_level_3:function(){
            try {
                if(this.navigation.nav[this.level_1_index].child.length > 0){
                    return true
                }else{
                    return false
                }
            } catch (error) {
                return false
            }
        }
    },
    created() {
        if (this.$route.name == 'navigations-edit') {
            if (typeof (this.$route.params.nav) == 'undefined') {
                axios.get("/navigations/" + this.$route.params.id).then((res) => {
                    this.navigation = res.data
                    // console.log(this.navigation.nav[this.level_1_index].child)
                }).catch((err) => {
                    this.$Message.error("获取导航信息失败！请刷新重试");
                })
            } else {
                this.navigation = this.$route.params.nav
            }
        }
        // console.log(this.navigation.nav[this.level_1_index].child)
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

                &:last-child {
                    .navigation-edit-title {
                        border-right: solid 1px #3288df;
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


