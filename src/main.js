// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import store from './store'
import router from './router'
import iView from 'iview'
import VueResource from 'vue-resource'
import VueClipboards from 'vue2-clipboards'
import 'iview/dist/styles/iview.css'

Vue.use(iView)
Vue.use(VueResource)
Vue.use(VueClipboards)
Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
