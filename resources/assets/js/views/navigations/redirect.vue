<template>
    <div id="redirect" class="root-element">
        <breadcrumb>
            <div slot="left">
                <Button @click="back">返回</Button>
                <Button type="success">新增网址重定向</Button>
            </div>
            <div slot="right">

            </div>
        </breadcrumb>

        <SearchBar>
            <div slot="form">
                <Row>
                    <Col span="6">
                    <FormItem label="输入框">
                        <Input placeholder="请输入"></Input>
                    </FormItem>
                    </Col>
                </Row>

            </div>
            <div slot="left-tool">
                <Button type="error" disabled>删 除</Button>
            </div>
        </SearchBar>
        
    </div>
</template>
<script>
import breadcrumb from '../../components/Breadcrumb.vue'
import SearchBar from '../../components/SearchBar.vue'
export default {
    data: () => ({
        loading: false
    }),
    components: {
        breadcrumb,
        SearchBar
    },
    methods: {
        back: function() {
            this.$router.go(-1)
        }
    }
}
</script>
<style lang="scss" scoped>
.ivu-form-item {
    margin-top: 12px;
    margin-bottom: 12px;
}
</style>