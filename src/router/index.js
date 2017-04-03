import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/layouts/Home'
import FAQ from '@/layouts/FAQ'
import OpenSource from '@/layouts/OpenSource'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/faq',
      name: 'FAQ',
      component: FAQ
    },
    {
      path: '/opensource',
      name: 'OpenSource',
      component: OpenSource
    }
  ],
  scrollBehavior (to, from, savedPosition) {
		return savedPosition || { x: 0, y: 0 };
	}
})

// 将路由和导航栏关联在一起
router.beforeEach((to, from, next) => {
  router.app.$store.commit('navbarActive', to.name)
  next()
})

export default router
