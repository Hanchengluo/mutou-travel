<template>
    <div id="search-bar">
        <div class="grid" v-show="!toggle_status">
            <Form ref="search" :label-width="120">
                <div class="form-slot">
                    <slot name="form">

                    </slot>
                </div>
                <div class="handler">
                    <Button icon="search" type="success">查找</Button>
                    <Button>重置</Button>
                </div>
            </Form>
        </div>
        <div class="tool">
            <div class="left">
                <Button icon="refresh" class="refresh-btn"></Button>
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
                    <span class="count">共 <strong>0</strong> 条记录</span>
                    <Select style="width:60px" placeholder="1/1">
                        <Option value="1">1</Option>
                    </Select>
                    <ButtonGroup>
                        <Button>
                            <Icon type="chevron-left"></Icon>
                        </Button>
                        <Button>
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
        toggle_status: false
    }),
    methods: {
        toggleGrid: function() {
            this.toggle_status = !this.toggle_status
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
                span.count{
                    color: #aaa;
                    font-size: 14px;
                    strong{
                        font-weight: bold;
                        color: #777;
                    }
                }
                .ivu-select{
                    margin-left: 10px;
                    margin-right: 10px;
                }
            }
        }
    }
}
</style>
