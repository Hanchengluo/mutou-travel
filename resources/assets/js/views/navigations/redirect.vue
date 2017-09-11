<template>
    <div id="redirect" class="root-element">
        <breadcrumb>
            <div slot="left">
                <Button @click="back">返回</Button>
                <Button type="success" @click="create">新增网址重定向</Button>
            </div>
            <div slot="right">

            </div>
        </breadcrumb>

        <SearchBar :searchHander="searchHander" :resetHander="resetHander" :refreshHander="refreshHander" :page="redirects" :goPage="goPage" :loading="loading">
            <div slot="form">
                <Form ref="search" :label-width="120">
                    <Row>
                        <Col span="6">
                        <FormItem label="搜索：">
                            <Input placeholder="请输入网址/描述"></Input>
                        </FormItem>
                        </Col>
                        <Col span="8">
                        <FormItem label="状态码：">
                            <CheckboxGroup>
                                <Checkbox label="300"></Checkbox>
                                <Checkbox label="301"></Checkbox>
                                <Checkbox label="302"></Checkbox>
                                <Checkbox label="303"></Checkbox>
                                <Checkbox label="304"></Checkbox>
                                <Checkbox label="305"></Checkbox>
                                <Checkbox label="307"></Checkbox>
                            </CheckboxGroup>
                        </FormItem>
                        </Col>
                    </Row>
                </Form>
            </div>
            <div slot="left-tool">
                <Button type="error" disabled>删 除</Button>
            </div>
        </SearchBar>

        <div class="layout-content">

            <div class="table-row">
                <Table stripe :columns="columns" :data="redirects.data" :context="this"></Table>

                <Page :total="redirects.total" :current="redirects.current_page" v-on:on-change="jump" show-total show-elevator></Page>
            </div>

            <Spin size="large" fix v-if="loading"></Spin>
        </div>

        <Modal v-model="edit_model" :title="model_title" @on-ok="save" @on-cancel="cancel" :mask-closable="false" :loading="model_loadding">
            <Form label-position="top" ref="formRedirect" :model="formData" :rules="formValidate">
                <FormItem label="访问网址:" prop="url">
                    <Input placeholder="请输入要跳转的网址" v-model="formData.url">
                    <span slot="prepend">{{ host }}</span>
                    </Input>
                </FormItem>
                <FormItem label="重定向至:" prop="redirect">
                    <Input placeholder="请输入重定向目标网址" v-model="formData.redirect"></Input>
                </FormItem>
                <FormItem label="http状态码">
                    <Select placeholder="请选择状态码" v-model="formData.code">
                        <Option :value="300">300 - 多种选择</Option>
                        <Option :value="301">301 - 永久移动</Option>
                        <Option :value="302">302 - 临时移动</Option>
                        <Option :value="303">303 - 查看其它地址</Option>
                        <Option :value="304">304 - 未修改</Option>
                        <Option :value="305">305 - 使用代理</Option>
                        <Option :value="307">307 - 临时重定向,与302类似</Option>
                    </Select>
                </FormItem>
                <FormItem label="描述:">
                    <Input type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="请输入描述" v-model="formData.description"></Input>
                </FormItem>
            </Form>
        </Modal>

    </div>
</template>
<script>
import breadcrumb from '../../components/Breadcrumb.vue'
import SearchBar from '../../components/SearchBar.vue'
export default {
    data() {
        return {
            loading: false,
            page_path: '',
            edit_model: false,
            model_title: '新增网址重定向',
            model_loadding: true,
            formData: {
                url: '/',
                redirect: '',
                code: 301,
                description: ''
            },
            formValidate: {
                url: [
                    { required: true, message: '访问网址不能为空', trigger: 'blur' },
                    {
                        validator: (rule, value, callback) => {
                            axios.post('redirect/validata', this.formData).then((res) => {
                                callback()
                            }).catch((err) => {
                                callback(new Error('访问网址重复'))
                            })
                        }, trigger: 'blur'
                    }
                ],
                redirect: [
                    { required: true, message: '重定向目标网址不能为空', trigger: 'blur' }
                ]
            },
            columns: [
                {
                    type: 'selection',
                    width: 60,
                    align: 'center'
                },
                {
                    title: 'ID',
                    key: 'id',
                    width: 100,
                    sortable: true
                },
                {
                    title: '访问网址',
                    key: 'url'
                },
                {
                    title: '重定向至',
                    key: 'redirect'
                },
                {
                    title: '描述',
                    key: 'description'
                },
                {
                    title: 'http代码',
                    key: 'code',
                    filters: [
                        {
                            label: '300',
                            value: '300'
                        },
                        {
                            label: '301',
                            value: '301'
                        },
                        {
                            label: '302',
                            value: '302'
                        },
                        {
                            label: '303',
                            value: '303'
                        },
                        {
                            label: '304',
                            value: '304'
                        },
                        {
                            label: '305',
                            value: '305'
                        },
                        {
                            label: '307',
                            value: '307'
                        }
                    ],
                    filterMethod(value, row) {
                        return row.code == value
                    }
                },
                {
                    title: '操作',
                    key: 'action',
                    width: 200,
                    align: 'center',
                    render: (h, params) => {
                        return h('div', [
                            h('Button', {
                                props: {
                                    type: 'success',
                                    size: 'small'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click: () => {
                                        this.edit(params.index)
                                    }
                                }
                            }, '修改'),
                            h('Button', {
                                props: {
                                    type: 'error',
                                    size: 'small'
                                },
                                on: {
                                    click: () => {
                                        this.toDestory(params.index)
                                    }
                                }
                            }, '删除')
                        ]);
                    }
                }
            ],
        }
    },
    components: {
        breadcrumb,
        SearchBar
    },
    methods: {
        back: function() {
            this.$router.go(-1)
        },
        searchHander: function() {
            alert(222)
        },
        resetHander: function() {

        },
        refreshHander: function() {
            this.loading = true
            this.$store.dispatch('get_redirects', this.page_path)
        },
        goPage: function(path) {
            this.loading = true
            this.page_path = path
            this.$store.dispatch('get_redirects', path)
        },
        jump: function(page) {
            const path = this.redirects.path + '?page=' + page
            this.goPage(path)
        },
        create: function() {
            this.formData = {
                url: '/',
                redirect: '',
                code: 301,
                description: ''
            }
            this.edit_model = true
            this.model_title = '新增网址重定向'
        },
        save: function() {
            this.$refs['formRedirect'].validate((valid) => {
                if (valid) {
                    if (this.formData.id == undefined) {
                        this.$store.dispatch('store_redirect', this.formData)
                    } else {
                        this.$store.dispatch('update_redirect', this.formData)
                    }
                } else {
                    this.model_loadding = false
                    this.$Message.error('表单验证失败!');
                }
            })

        },
        cancel: function() {

        },
        edit: function(index) {
            this.edit_model = true
            this.model_title = '编辑网址重定向'
            this.formData = this.redirects.data[index]
        },
        toDestory:function(index){
            this.destroy(this.redirects.data[index].id)
        },
        destroy:function(id){
            if (typeof(id) == Array) {
                id = id.join(',')
            }
            this.$store.dispatch('destroy_redirect',id)
        }

    },
    computed: {
        redirects: function() {
            this.edit_model = false
            this.formData = {
                url: '/',
                redirect: '',
                code: 301,
                description: ''
            }
            return this.$store.state.redirects
        },
        host: function() {
            return window.location.protocol + "//" + window.location.host
        }
    },
    created: function() {
        const _this = this
        axios.interceptors.response.use(function(response) {
            _this.loading = false
            return response;
        }, function(error) {
            _this.loading = false
            return Promise.reject(error);
        });
        this.loading = true
        this.$store.dispatch('get_redirects')

    }
}
</script>
<style lang="scss" scoped>
#search-bar {
    .ivu-form-item {
        margin-top: 12px;
        margin-bottom: 12px;
    }
}


.table-row {
    padding: 40px 30px;
    .ivu-page {
        margin-top: 30px;
        float: right;
    }
}

.layout-content {
    height: 100%;
    overflow-y: auto;
    position: relative;
}
</style>