<template>
    <div id="navigations">
        <breadcrumb>
            <div slot="left">
                <Button type="info">新增导航</Button>
            </div>
            <div slot="right">
                <Button type="info">新增导航分组</Button>
                <Button type="info">网址重定向</Button>
            </div>
        </breadcrumb>
    </div>
</template>
<script>
import breadcrumb from '../../components/Breadcrumb.vue'
export default {
    data: () => ({

    }),
    components: {
        breadcrumb
    },
    computed: {

    },
    created() {
        // console.log(this.$route);
    }
}
</script>
<style lang="scss" scoped>

</style>

