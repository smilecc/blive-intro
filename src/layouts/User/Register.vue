<template>
  <div>
    <div v-title>注册</div>
    <div class="container">
      <h1>注册</h1>
      <Form ref="formCustom" :model="form" :label-width="80" class="form">
        <Alert show-icon class="tips">
            提示
            <Icon type="ios-lightbulb-outline" slot="icon"></Icon>
            <template slot="desc">注册后您可以享受 <strong>免费的图片上传、一键把简介发布到直播间、自动获取直播间地址</strong> 等功能。</template>
        </Alert>
        <FormItem label="用户名">
            <Input type="text" v-model="form.username" placeholder="请输入用户名">
              <Icon type="ios-person-outline" slot="prepend"></Icon>
            </Input>
        </FormItem>
        <FormItem label="电子邮箱">
            <Input type="text" v-model="form.email" placeholder="请输入电子邮箱">
              <Icon type="email" slot="prepend"></Icon>
            </Input>
        </FormItem>
        <FormItem label="密码">
            <Input type="password" v-model="form.password" placeholder="请输入密码">
              <Icon type="ios-locked-outline" slot="prepend"></Icon>
            </Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="onSubmit">立即注册</Button>
            <Button type="ghost" @click="goLogin" style="margin-left: 8px">已经有账户？点此登录</Button>
        </FormItem>
      </Form>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      form: {
        username: '',
        email: '',        
        password: ''
      }
    }
  },
  methods: {
    onSubmit () {
      this.$http.post('http://api.bintro.smilec.cc/v1/user/register', {
        username: this.form.username,
        email: this.form.email,
        password: this.form.password
      }, { emulateJSON: true }).then(response => {
        let body = response.body
        console.log(body)
        if (body.code === 1) {
          this.$store.commit('setUserToken', body.token)
          this.$Notice.success({
            title: 'Success',
            desc: body.msg
          })
          this.$router.replace('/user/cookie')
        } else {
          this.$Modal.error({
            title: '登录失败',
            content: body.msg
          })
        }
      })
    },
    goLogin () {
      this.$router.push('/user/login')
    }
  }
}
</script>

<style scoped>
.form {
  width: 600px;
  margin: 0 auto;
}
.tips {
  margin-top: 30px;
  margin-bottom: 30px;
}
</style>
