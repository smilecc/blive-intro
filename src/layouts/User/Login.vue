<template>
  <div>
    <div v-title>登录</div>
    <div class="container">
      <h1>登录</h1>
      <Form ref="formCustom" :model="form" :label-width="80" class="form">
        <Alert show-icon class="tips">
            提示
            <Icon type="ios-lightbulb-outline" slot="icon"></Icon>
            <template slot="desc">登录后您可以享受免费的图片上传、一键设置简介等功能。</template>
        </Alert>
        <FormItem label="账户">
            <Input type="text" v-model="form.account" placeholder="请输入用户名/邮箱">
              <Icon type="ios-person-outline" slot="prepend"></Icon>
            </Input>
        </FormItem>
        <FormItem label="密码">
            <Input type="password" v-model="form.password" placeholder="请输入密码">
              <Icon type="ios-locked-outline" slot="prepend"></Icon>
            </Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="onSubmit">登录</Button>
            <Button type="ghost" @click="goRegister" style="margin-left: 8px">立即注册</Button>
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
        account: '',
        password: ''
      }
    }
  },
  methods: {
    onSubmit () {
      this.$http.post('http://api.bintro/v1/user/login', {
        account: this.form.account,
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
          this.$router.replace('/user/profile')
        } else {
          this.$Modal.error({
            title: '登录失败',
            content: body.msg
          })
        }
      })
    },
    goRegister () {
      this.$router.push('/user/register')
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
