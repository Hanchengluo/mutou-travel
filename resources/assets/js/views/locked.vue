<template>
<div id="locked">
    <header>
        <div class="avatar">
            <img :src="user.avatar | avatar('avatar.200')">
        </div>
    </header>
    <div class="panel">
        <Form ref="locked" :model="locked" :rules="locked_rule">
            <Form-item prop="password">
                <Input size='large' type='password' placeholder='输入密码以解锁' v-model="locked.password">
                <Button slot="append" html-type="submit" icon="unlocked" @click="handleSubmit('locked')"></Button>
                </Input>
            </Form-item>
        </Form>
    </div>
</div>
</template>

<script>
export default {
    name: "locked",
    data: () => ({
        locked:{
            password:''
        },
        locked_rule:{
            password: [
                { required: true, message: '请填写密码', trigger: 'blur' },
            ]
        }
    }),
    computed:{
        user:function(){
            return JSON.parse(window.localStorage.getItem('user'))
        }
    },
    methods:{
        handleSubmit(name){
             this.$refs[name].validate((valid) => {
                 if (valid) {
                     const data = {
                         'id':this.user.id,
                         'password':this.locked.password,
                         'obj':this
                     }
                     this.$store.dispatch('unLocked',data);
                 }else{
                     this.$Message.error('请填写密码!');
                 }
             })
        }
    }
}
</script>

<style lang="scss" scoped>
#locked {
    width: 100%;
    height: 100%;
    background-image: url('/images/locked-bg.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    header {
        display: block;
        width: 100%;
        height: 360px;
        text-align: center;
        line-height: 190px;
        margin: 0;
        overflow: hidden;
        div.avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #fff;
            margin: 220px auto auto auto;
            overflow: hidden;
            padding: 0;
            img {
                display: block;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }
        }
    }
    .panel {
        width: 100%;
        max-width: 360px;
        margin: 0 auto;
        padding: 0 10px;
        opacity: .8;
        .ivu-input-wrapper {
            height: 46px;
            .ivu-input {
                height: 46px;
            }
        }
    }
}
</style>

<style>
#locked .ivu-input.ivu-input-large {
    height: 46px!important;
}
</style>
