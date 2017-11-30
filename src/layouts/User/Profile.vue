<template>
  <div class="article">
    <div v-title>用户</div>
    <div class="userinfo">
      <div class="container user-panel">
        <Card :bordered="false">
          <p slot="title">欢迎回来，{{ user.username }}</p>
          <a href="#" slot="extra" @click.prevent="exitLogin">
            <Icon type="android-exit"></Icon>
            退出登录
          </a>
          <p>电子邮箱：{{ user.email }}</p>
          <p>注册时间：{{ user.register_time }}</p>
        </Card>
      </div>
    </div>
    <div class="container">
      <Card>
        <p slot="title">Bilibili Cookie <small class="subtitle">只有设置Cookie才能使用一键设置简介的功能</small></p>
        <a href="#" slot="extra" @click.prevent="$router.push('/user/cookie')">
          <Icon type="ios-gear"></Icon>
          设置Cookie
        </a>
        <p class="cookie-content">{{ user.cookie ? user.cookie : '尚未设置Cookie' }}</p>
      </Card>
    </div>

    <div class="container">
      <Card>
        <p slot="title">图片列表</p>
        <p class="cookie-content">
          <Row span="4" v-for="(item, index) in user.image_list" :key="index">
            <Col span="4" class="img-box">
              <img class="img-item" :src="item.url" alt="">
            </Col>
            <Col span="20" class="img-info">
              <h4>{{ item.filename }} <small class="subtitle">{{ item.created_time }}</small></h4>
              <Input v-model="item.url" readonly>
                  <span slot="prepend">图片地址</span>
              </Input>
            </Col>
          </Row>
        </p>
      </Card>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import Store from '@/store'

export default {
  data () {
    return {
      user: {}
    }
  },
  beforeRouteEnter: (to, from, next) => {
    let userToken = Store.state.user.userToken
    if (userToken && userToken.length > 0) {
      next(vm => {
        vm.loading(true)
        vm.$http.post('http://api.bintro/v1/user/info', {
          user_token: vm.userToken
        }, { emulateJSON: true }).then(response => {
          let body = response.body
          if (body.code === 1) {
            vm.user = body.user
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
    exitLogin () {
      this.$Modal.confirm({
        title: '确认',
        content: '是否确认要退出登录？',
        onOk: () => {
          this.$store.commit('setUserToken', '')
          this.$router.replace('/user/login')
        },
        onCancel: () => {}
      })
    }
  }
}
</script>

<style scoped>
.userinfo {
  background: #eee;
  padding: 40px 0;
}
.user-panel {
  margin-top: 0;
}
.cookie-content {
  white-space: normal;
  word-break: break-all;
}
.subtitle {
  color: #555;
  font-weight: normal;
}
.img-info {
  padding: 25px 0;
}
.img-info > p {
  line-height: 1.5;
}
.img-item {
  height: 100px;
  max-width: 85%;
  margin: 10px auto;
}
.article {
  padding-bottom: 30px;
}
</style>
