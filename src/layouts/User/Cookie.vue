<template>
  <div>
    <div v-title>设置Cookie</div>
    <div class="container">
      <h1>设置Cookie</h1>
      <Row :gutter="16">
        <Col span="12">
          <Input v-model="cookie" type="textarea" :autosize="{minRows: 5, maxRows: 10}" placeholder="请在此输入Cookie..."></Input>
          <p>我们保证不会滥用您的Cookie</p>
          
          <Button type="primary" long style="margin-top: 10px;" @click="onSubmit">提交 Cookie</Button>
          <Button type="success" long style="margin-top: 10px;" @click="$router.push('/')" v-if="isSave">保存成功，点此去生成简介卡</Button>
          
        </Col>
        <Col span="12">
          <Alert show-icon>如果您不知道如何获取Cookie，请看这里</Alert>
          <h3>1. 下载Bilibili Cookie 获取工具</h3>
          <p class="desc">安装版安装之后会自动打开，您可以在桌面找到名为blive-cookie的快捷方式再次打开它，如果你不想安装，建议您使用压缩版，压缩版在解压之后，打开文件夹内的blive-cookie.exe即可使用。</p>
          <p>安装版（33.00MB）：<a href="http://bintro-1251918581.file.myqcloud.com/win32-blive-cookie-setup-1.0.exe">点击下载</a></p>          
          <p>压缩版（52.09MB）：<a href="http://bintro-1251918581.file.myqcloud.com/win32-blive-cookie-1.0.zip">点击下载</a></p>

          <h3>2. 打开软件登录B站账户，获取Cookie</h3>
          <p class="desc">登录后，Cookie获取工具右侧的文本框内将会出现我们所要获取的Cookie，将获取到的Cookie复制并填入本页面左侧的输入框，点击提交即可。</p>

          <h3>3. Cookie获取工具已开源</h3>
          <p class="desc">获取工具已经开源，如果您不放心或存在任何问题，可以到<a href="https://github.com/smilecc/blive-cookie" target="_blank">Github</a>审视代码、提交issue。</p>
        </Col>
      </Row>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import Store from '@/store'

export default {
  data () {
    return {
      cookie: '',
      isSave: false
    }
  },
  beforeRouteEnter: (to, from, next) => {
    let userToken = Store.state.user.userToken
    if (userToken && userToken.length > 0) {
      next(vm => {
        vm.loading(true)
        vm.$http.post('http://api.bintro.smilec.cc/v1/user/info', {
          user_token: vm.userToken
        }, { emulateJSON: true }).then(response => {
          let body = response.body
          if (body.code === 1) {
            vm.cookie = body.user.cookie
          } else {
            vm.$Modal.error({
              title: '身份信息失效',
              content: body.msg
            })
            vm.$router.replace('/user/login')
          }
          vm.loading(false)
        })
      })
    } else {
      next('/user/login')
    }
  },
  computed: {
    ...mapState({
      userToken: state => state.user.userToken
    })
  },
  methods: {
    loading (state) {
      if (state) {
        this.$Spin.show()
      } else {
        this.$Spin.hide()
      }
    },
    onSubmit () {
      this.loading(true)
      this.$http.post('http://api.bintro.smilec.cc/v1/user/set_cookie', {
        user_token: this.userToken,
        cookie: this.cookie
      }, { emulateJSON: true }).then(response => {
        let body = response.body
        if (body.code === 1) {
          this.$Notice.success({
            title: 'Success',
            desc: body.msg
          })
          this.isSave = true
        } else {
          this.$Modal.error({
            title: '登录失败',
            content: body.msg
          })
        }
        this.loading(false)
      })
    }
  }
}
</script>

<style scoped>
.subtitle {
  color: #555;
  font-weight: normal;
}
.desc {
  line-height: 1.6;
  font-size: 15px !important;
  margin: 10px 0;
}
</style>
