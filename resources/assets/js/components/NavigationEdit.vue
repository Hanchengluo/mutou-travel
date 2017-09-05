<template>
    <div id="navigation-edit">
        <div class="navigation-edit-lists" v-if="edit">
            <div class="navigation-edit-lists-header">
                <div class="item">显示名称</div>
                <div class="item">标识字符</div>
                <div class="item">链接地址</div>
                <div class="item">导航图标</div>
                <div class="item">是否显示</div>
                <div class="item">跳转方式</div>
            </div>
            <div class="navigation-edit-lists-items">
                <Form ref="navigationEdit" :model="navigation">
                    <draggable v-model="navigation.nav" :options="{handle:'.ivu-icon-android-more-vertical'}">
                        <transition-group name="list" tag="p">
                            <FormItem v-for="(nav, index) in navigation.nav" :track-by="nav.sort" :key="index" :prop="'nav.' + index" :rules="{type:'object', required: true,fields:{display_name:{type:'string',required: true,message: '显示名称不能为空'},name:[{type:'string',required: true,message: '标识字符不能为空'},{
                                        validator: function(rule, value, callback) {
                                            validata_name(rule, value, callback,nav.id)
                                        }, trigger: 'blur'
                                    }]}}">
                                <div class="navigation-edit-lists-items-row" v-bind:class="{ active: current_index == index }" v-on:click="current(index)">
                                    <div class="item name">
                                        <Icon type="android-more-vertical"></Icon>
                                        <Input placeholder="显示名称" v-model.trim="nav.display_name"></Input>
                                    </div>
                                    <div class="item">
                                        <Input placeholder="英文标识" v-model.trim="nav.name"></Input>
                                    </div>
                                    <div class="item link">
                                        <Input placeholder="链接地址" v-model.trim="nav.url">
                                        <Button slot="append" icon="ios-box"></Button>
                                        </Input>
                                    </div>
                                    <div class="item">
                                        <navicon :icon="nav.icon" :type="nav.icon_type"></navicon>&nbsp;&nbsp;
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
                                        <Button type="error" @click="delete_one(nav)">
                                            <Icon type="trash-a"></Icon>
                                        </Button>
                                    </div>
                                </div>
                            </FormItem>
                        </transition-group>
                    </draggable>
                </Form>
                <div class="add-button">
                    <Button @click="add_one_item()">新增一项</Button>
                </div>
            </div>
        </div>

        <div class="navigation-show-list" v-else v-on:mouseenter="is_hover=true" v-on:mouseleave="is_hover=false">
            <Button type="success" size="small" icon="edit" @click="act(level)" class="edit" v-if="!edit && is_hover">编辑</Button>
            <div class="navigation-show-list-title" v-if="parent">
                {{parent.display_name}} 子菜单
            </div>
            <div class="navigation-show-list-row" v-if="navigation.nav.length > 0">
                <div class="item" v-for="(nav, index) in navigation.nav" :key="index" v-bind:class="{ active: current_index == index }">
                    <Icon type="android-more-vertical"></Icon>
                    <strong>{{nav.display_name}}</strong>
                </div>
            </div>
            <div class="add-sub-nav" v-else>
                <Button type="success" long @click="act(level)">添加子菜单</Button>
            </div>
        </div>
    </div>
</template>
<script>
import navicon from './Navicon.vue'
import draggable from 'vuedraggable'
export default {
    data: () => ({
        current_index: 0,
        is_hover: false,
        nav: {},
    }),
    props: {
        navigations: {
            type: Array,
            required: true
        },
        edit: {
            type: Boolean,
            default: false
        },
        act: {
            type: Function
        },
        level: {
            type: Number,
            default: 1
        },
        parent: false
    },
    components: {
        navicon,
        draggable
    },
    computed: {
        navigation: {
            get() {
                this.$set(this.nav, 'nav', this.navigations)
                return this.nav
            },
            set(value) {
                for (var i = 0; i < value.length; i++) {
                    value[i].sort = i
                }
                this.nav.nav = value
            }
        }
    },
    methods: {
        add_one_item: function() {
            this.navigation.nav.push({
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
            })
            console.log(this.navigation.nav)
        },
        delete_one: function(nav) {
            this.$Modal.confirm({
                title: '删除菜单项',
                content: '<p>确认要删除菜单项 <strong>' + nav.display_name + '</strong> 吗？</p><p>对应的子菜单也会被删除</p>',
                okText: '确认删除',
                onOk: () => {
                    this.nav.nav.splice(this.navigation.nav.indexOf(nav), 1)
                }
            });
        },
        current: function(index) {
            this.current_index = index
        },
        validata_name: function(rule, value, callback,id) {
            if (id != undefined && id != '') {
                value += '/'+id
            }
            axios.get('/navigations/validata/nav/' + value).then((res) => {
                if (res.data.status == 0) {
                    callback(new Error('导航标识已存在'))
                }
                callback();
            })
        }
    },
    watch: {
        nav: {
            handler: function(val, oldVal) {
                if (val.nav.length > 0) {
                    if (val.nav[0].name != '') {
                        this.$emit('listenNavigationsChangeEvent', {
                            navigations: val.nav,
                            currentIndex: this.current_index
                        })
                    }
                }
            },
            deep: true
        },
        current_index: {
            handler: function(val, oldVal) {
                if (val != oldVal) {
                    this.$emit('listenNavigationsChangeEvent', {
                        navigations: this.nav.nav,
                        currentIndex: val
                    })
                }
            }
        }
    }
}
</script>
<style lang="scss" scoped>
div#navigation-edit {
    .icon {
        width: 18px;
        height: 18px;
    }

    .navigation-edit-lists {
        width: calc(100% - 10px);
        height: auto;
        border: solid 1px #3288df;
        margin-right: 10px;
        transition: all .2s ease-in-out;
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
            .ivu-form-item {
                margin: 0;
            }
            .navigation-edit-lists-items-row {
                height: 50px;
                line-height: 50px;
                border-bottom: solid 1px #b4cfea;
                display: flex;
                padding-top: 4px;
                i.ivu-icon {
                    font-size: 14px!important;
                }
                &.active {
                    background-color: #f2f7fb;
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
                            cursor: move;
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
    .navigation-show-list {
        width: calc(100% - 10px);
        height: auto;
        border: solid 1px #3288df;
        margin-right: 10px;
        position: absolute;
        transition: all .2s ease-in-out;
        .navigation-show-list-title {
            width: 100%;
            height: 45px;
            line-height: 45px;
            border-bottom: 1px solid #b4cfea;
            background-color: #f2f7fb;
            color: #246;
            padding: 0 10px;
        }
        .navigation-show-list-row {
            height: auto;
            line-height: 50px;
            border-bottom: solid 1px #b4cfea;
            .item {
                width: 100%;
                height: 50px;
                line-height: 50px;
                border-bottom: solid 1px #b4cfea;
                i.ivu-icon {
                    font-size: 14px;
                    width: 20px;
                    text-align: center;
                    color: #57a3f3;
                    cursor: pointer;
                }
                strong {
                    font-size: 14px;
                    font-weight: normal;
                }
                &:last-child {
                    border-bottom: none;
                }
                &.active {
                    background-color: #f2f7fb;
                }
            }
        }
        .add-sub-nav {
            padding: 20px;
        }

        .edit {
            position: absolute;
            right: 10px;
            top: 10px;
        }
    }
}




.list-enter-active,
.list-leave-active {
    transition: all .2s;
}

.list-enter,
.list-leave-to
/* .list-leave-active for below version 2.1.8 */

{
    opacity: 0;
    transform: translateY(30px);
}
</style>
<style lang="scss">
#navigation-edit .navigation-edit-lists-items div.ivu-form-item-error-tip {
    display: inline-block;
    width: auto;
    height: 30px;
    line-height: 30px;
    position: absolute;
    right: -110px!important;
    left: auto;
    padding: 0;
    background-color: #ed3f14;
    color: #fff;
    z-index: 1;
    padding: 0px 5px;
    border-radius: 4px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, .2);
    white-space: nowrap;
    top: 12px;
    &::before {
        content: ' ';
        left: -5px;
        top: 10.5px;
        border-width: 5px 5px 5px 0;
        border-color: transparent;
        border-right-color: #ed3f14;
        position: absolute;
        width: 0;
        height: 0;
        border-style: solid;
    }
}

#navigation-edit {
    .ivu-form-item-error {
        .item.link {
            .ivu-input {
                border: solid 1px #dddee1!important;
            }
            .ivu-input-group-append {
                border: solid 1px #dddee1!important;
                border-left: none!important;
            }
        }
        .ivu-select-selection {
            border: solid 1px #dddee1!important;
            .ivu-select-arrow {
                color: #80848f;
            }
        }
    }
}
</style>
