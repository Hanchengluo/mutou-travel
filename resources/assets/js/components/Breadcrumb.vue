<template>
    <div id="breadcrumb">
        <div class="page-title">
            <slot name="title">
                <navicon :icon="navigation.icon" :type="navigation.icon_type"></navicon>
                <h2>{{navigation.display_name}}</h2>
            </slot>
        </div>
        <div class="action left-action">
            <slot name="left">

            </slot>
        </div>
        <div class="action right-action">
            <slot name="right">

            </slot>
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
    computed: {
        navigation: function() {
            const nav = this.$store.state.navigations
            for (var i = 0; i < nav.length; i++) {
                if (nav[i].name == this.$route.name) {
                    return nav[i]
                } else {
                    if (nav[i].child.length > 0) {
                        for (var t = 0; t < nav[i].child.length; t++) {
                            if (nav[i].child[t].name == this.$route.name) {
                                return nav[i].child[t]
                            } else {
                                if (nav[i].child[t].child != undefined) {
                                    if (nav[i].child[t].child.length > 0) {
                                        for (var s = 0; s < nav[i].child[t].child.length; s++) {
                                            if (nav[i].child[t].child[s].name == this.$route.name) {
                                                return nav[i].child[t].child[s]
                                            }
                                        }

                                    }
                                } else {
                                    return {
                                        icon: 'ios-grid-view-outline',
                                        icon_type: 0,
                                        display_name: '控制面板'
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return {
                icon: 'ios-grid-view-outline',
                icon_type: 0,
                display_name: '控制面板'
            }
        }
    }
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
            color: #246;
        }
    }
    div.action {
        width: auto;
        height: 56px;
        line-height: 56px;
        &.left-action {
            float: left;
        }
        &.right-action {
            float: right;
            padding-right: 10px;
        }
    }
}
</style>

