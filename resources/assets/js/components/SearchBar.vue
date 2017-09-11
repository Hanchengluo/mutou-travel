<template>
    <div id="search-bar">
        <div class="grid" v-show="!toggle_status">
            <div class="form-slot">
                <slot name="form">

                </slot>
            </div>
            <div class="handler">
                <Button icon="search" type="success" @click="searchHander">查找</Button>
                <Button @click="resetHander">重置</Button>
            </div>
        </div>
        <div class="tool">
            <div class="left">
                <Button icon="refresh" class="refresh-btn" @click="refreshHander" :loading="loading"></Button>
                <div class="left-slot">
                    <slot name="left-tool">

                    </slot>
                </div>
            </div>
            <div class="right">
                <a class="toggle-grid" @click="toggleGrid">
                    <Icon v-if="!toggle_status" type="android-arrow-dropup"></Icon>
                    <Icon v-else type="android-arrow-dropdown"></Icon>
                </a>
                <div class="page">
                    <span class="count">共
                        <strong>{{page.total}}</strong> 条记录</span>
                    <Select style="width:60px" placeholder="1/1" v-model="select_page" :disabled="pageOptions.length <= 1" v-on:on-change="jump">
                        <Option v-for="opt in pageOptions" :value="opt.value" :key="opt.value">{{opt.text}}</Option>
                    </Select>
                    <ButtonGroup>
                        <Button @click="prevPage" :disabled="page.prev_page_url == null">
                            <Icon type="chevron-left"></Icon>
                        </Button>
                        <Button @click="nextPage" :disabled="page.next_page_url == null">
                            <Icon type="chevron-right"></Icon>
                        </Button>
                    </ButtonGroup>
                </div>
                <slot name="right-tool">

                </slot>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: () => ({
        toggle_status:false,
        select_page:1,
    }),
    props:{
        searchHander:{
            type:Function,
            required:true
        },
        resetHander:{
            type:Function,
            required:true 
        },
        refreshHander:{
            type:Function,
            required:true
        },
        page:{
            required:true
        },
        goPage:{
            type:Function,
            required:true
        },
        gridShow:{
            type:Boolean,
            default:false
        },
        loading:{
            type:Boolean,
            default:false
        }

    },
    methods: {
        toggleGrid: function() {
            this.toggle_status = !this.toggle_status
        },
        nextPage:function(){
            this.goPage(this.page.next_page_url)
        },
        prevPage:function(page){
            this.goPage(this.page.prev_page_url)
        },
        jump:function(value){
            this.goPage(this.page.path + '?page='+value)
        }
    },
    created:function(){
        this.toggle_status = this.gridShow
    },
    computed:{
        pageOptions:function(){
            const opt = []
            for (var i = 0; i < this.page.last_page; i++) {
                opt.push({
                    value:i+1,
                    text:i+1+'/'+this.page.last_page
                })
            }
            return opt
        }
    }
}
</script>
<style lang="scss" scoped>
#search-bar {
    width: 100%;
    height: auto;
    .grid {
        width: 100%;
        height: auto;
        background-color: #f7f7f7;
        border-bottom: solid 1px #e6e9f0;
        overflow: hidden;
        .form-slot {
            padding: 10px;
            width: 100%;
            height: auto;
            .ivu-form-item {
                margin-top: 12px;
                margin-bottom: 12px;
            }
        }
        .handler {
            width: 100%;
            height: auto;
            text-align: center;
            padding: 10px 0;
            margin-top: 10px;
            border-top: 1px dashed #D3D3D3;
        }
    }
    .tool {
        width: 100%;
        height: 50px;
        line-height: 50px;
        border-bottom: solid 1px #e6e9f0;
        background-color: #fff;
        padding: 0px 20px;
        .left {
            float: left;
            &:before {
                content: " ";
                display: table;
            }
            &:after {
                content: " ";
                display: table;
                clear: both;
            }
            .refresh-btn {
                float: left;
                margin-top: 9px;
            }
            .left-slot {
                height: 50px;
                ;
                float: left;
                padding-left: 10px;
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
        }
        .right {
            float: right;
            &:before {
                content: " ";
                display: table;
            }
            &:after {
                content: " ";
                display: table;
                clear: both;
            }
            .toggle-grid {
                display: block;
                width: 44px;
                height: 40px;
                border: solid 1px #e6e9f0;
                border-top: none;
                border-bottom-left-radius: 4px;
                border-bottom-right-radius: 4px;
                margin-top: -1px;
                background-color: #f7f7f7;
                line-height: 40px;
                text-align: center;
                font-size: 24px;
                color: #aaa;
                float: right;
            }
            .page {
                float: right;
                width: auto;
                height: 50px;
                line-height: 50px;
                padding-right: 20px;
                span.count {
                    color: #aaa;
                    font-size: 14px;
                    strong {
                        font-weight: bold;
                        color: #777;
                    }
                }
                .ivu-select {
                    margin-left: 10px;
                    margin-right: 10px;
                }
            }
        }
    }
}
</style>
