<template>
    <div id="breadcrumb">
        <div class="page-title">
            <navicon></navicon>
            <h2>导航管理</h2>
        </div>
        <div class="action left-action">
            <slot name="left">
                <Button type="info">信息按钮</Button>
            </slot>
        </div>
        <div class="action right-action">
            <slot name="right"></slot>
        </div>
    </div>
</template>
<script>
import navicon from './Navicon.vue'
export default {
    data: () => ({

    }),
    components: {
        navicon
    },
}
</script>

<style lang="scss" scoped>
#breadcrumb {
    width: 100%;
    height: 56px;
    background-color: #fcfcfc;
    border-bottom: 1px solid #eee;
    padding: 0px 20px;
    &:before {
        content: " ";
        display: table;
    }
    &:after {
        content: " ";
        display: table;
        clear: both;
    }
    div.page-title {
        width: auto;
        height: 56px;
        line-height: 56px;
        float: left;
        padding-right: 30px;
        &:before {
            content: " ";
            display: table;
        }
        &:after {
            content: " ";
            display: table;
            clear: both;
        }
        .icon {
            display: block;
            width: 30px;
            height: 56px;
            line-height: 56px;
            float: left;
            font-size: 18px;
        }
        h2 {
            padding: 0;
            margin: 0;
            width: auto;
            height: 56px;
            line-height: 56px;
            float: left;
            font-weight: normal;
            color:#246;
        }
    }
    div.action{
        width: auto;
        height: 56px;
        line-height: 56px;
        &.left-action{
            float: left;
        }
        &.right-action{
            float: right;
            padding-right: 10px;
        }
    }
}
</style>

