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

import Cookie from './plugins/cookie'

import NavBanner from './components/Banner'
import Footerbar from '@/components/Footerbar'


Vue.component('nav-banner', NavBanner)
Vue.component('Footerbar', Footerbar)

Vue.use(iView)
Vue.use(VueResource)
Vue.use(VueClipboards)
Vue.use(Cookie)
Vue.config.productionTip = false

Vue.directive('title', {
  inserted: function (el) {
    document.title = el.innerText + ' - Bilibili Live 简介卡生成器'
    el.remove()
  }
})

new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
