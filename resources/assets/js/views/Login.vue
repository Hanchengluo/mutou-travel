<template>
  <div id="login">
      <header>
          <img src="../../images/logo.png">
      </header>
      <div class="login-panel">
          <Form ref="loginForm" :model="login" :rules="ruleLogin">
              <div class="field">
                  <Form-item prop="username">
                      <Input v-model="login.username" size="large" placeholder="邮箱地址/手机号码" style="height:46px;"></Input>
                      <a @click="login.username=''">
                      <Icon v-show='login.username != ""' type="ios-close-outline"></Icon>
                      </a>
                  </Form-item>
              </div>
              <div class="field pwd">
                  <Form-item prop="password">
                      <Input type="password" size="large" v-model="login.password" placeholder="登录密码" v-show="pwdType == 'password'" style="height:46px;"></Input>
                      <Input type="text" size="large" v-model="login.password" placeholder="登录密码" v-show="pwdType == 'text'" style="height:46px;"></Input>
                      <a @click="login.password=''">
                          <Icon v-show='login.password != ""' type="ios-close-outline"></Icon>
                      </a>
                      <a @click="pwdType='text'" v-show="pwdType == 'password'">
                          <Icon type="eye"></Icon>
                      </a>
                      <a @click="pwdType='password'" v-show="pwdType != 'password'">
                          <Icon type="eye-disabled"></Icon>
                      </a>
                  </Form-item>
              </div>
              <div class="field forgot-password">
                  <a href="#">忘记密码？</a>
              </div>
              <Button type="primary" html-type="submit" size="large" long class='login-btn' @click="handleSubmit('loginForm')">登  录</Button>
              <div class="horizontal-line"></div>
              <div class="socialite">
                  <Button type="ghost" size="large" long class='login-btn'>使用 微信 登录</Button>
              </div>
              <div class="legal">
                  Copyright (c) 2017 Copyright mutou.io All Rights Reserved.
              </div>
          </Form>
      </div>
  </div>
</template>
<script>
export default {
  data(){
      return {
          login:{
              username:'',
              password:'',
          },
          ruleLogin: {
              username: [
                  { required: true, message: '请填写用户名', trigger: 'blur' }
              ],
              password: [
                  { required: true, message: '请填写密码', trigger: 'blur' },
              ]
          },
          pwdType:'password'
      }
  },
  methods:{
      handleSubmit(name) {
          this.$refs[name].validate((valid) => {
                if (valid) {
                    this.$Message.loading({
                        content: '登录中...',
                        duration: 0
                    });
                    var loginData = {
                        'username':this.login.username,
                        'password':this.login.password,
                        'obj':this
                    }
                    this.$store.dispatch('login',loginData);
                } else {
                    this.$Message.error('表单验证失败!');
                }
            })
        }
  }
}
</script>
<style lang="scss" scoped>


    #login{
        width: 100%;
        height: 648px;
    }
    header{
        width: 100%;
        height: 190px;
        text-align: center;
        line-height: 190px;
        img{
            width: 64px;
            height: 64px;
            vertical-align: middle;
            margin-bottom: -80px;
        }
    }

    div.login-panel{
        width: 100%;
        max-width: 360px;
        margin: 0 auto;
        padding: 0 10px;
        form{
            display: block;
            margin-top: 0;
            .field{
                position: relative;
                &.pwd{
                    i.ivu-icon-ios-close-outline{
                        right: 36px;
                    }
                }
                i.ivu-icon{
                    position: absolute;
                    z-index: 1;
                    right: 10px;
                    top: 0;
                    line-height: 46px;
                    font-size: 18px;
                    color: #CCC;
                    font-weight: bold;
                    cursor: pointer;
                    &:hover{
                        color: #3da8f5;
                    }
                }
            }
            .forgot-password{
                display: none;
                position: relative;
                margin-top: -25px;
                font-size: 14px;
                line-height: 30px;
                height: 30px;
                margin-bottom: 0;
                a{
                    float: right;
                }
            }
            div.ivu-form-item{
                height: 46px;
                div.ivu-form-item-content{
                    height: 46px;
                    div.ivu-input-wrapper{
                        height: 46px;
                        .ivu-input{
                            height: 46px!important;
                            width: 100%;
                            margin-bottom: 25px;
                            padding: 12px;
                            font-size: 16px;
                            line-height: 20px;
                            -webkit-appearance: none;
                            border: 1px solid #ddd;
                            border-radius: 3px;
                            box-shadow: none;
                            transition: .15s;
                        }
                        .ivu-input:focus{
                            -webkit-appearance: none;
                            border-color: #a6a6a6;
                            outline: 0;
                        }
                    }
                }
            }
            .login-btn{
                height: 46px;
                margin-bottom: 25px;
                font-size: 16px;
            }
            .horizontal-line{
                width: 100%;
                height: 1px;
                background-color: #d9d9d9;
                margin-bottom: 25px;
            }
            .socialite{
                .ivu-btn-ghost {
                    color: #19be6b;
                    background-color: transparent;
                    border-color: #19be6b;
                }
                .ivu-btn-ghost:hover {
                    color: #fff;
                    background-color: #19be6b;
                    border-color: #19be6b;
                }
            }
            .legal{
                font-size: 12px;
                color: #eee;
            }
        }
    }

    :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        color: #ddd; opacity:1;
    }

    ::-moz-placeholder { /* Mozilla Firefox 19+ */
        color: #ddd;opacity:1;
    }

    input:-ms-input-placeholder{
        color: #ddd;opacity:1;
    }

    input::-webkit-input-placeholder{
        color: #ddd;opacity:1;
    }

</style>
<style>
.login-panel .ivu-input.ivu-input-large{
        height: 46px!important;
    }
</style>
