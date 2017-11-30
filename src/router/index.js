import Vue from 'vue'
import Router from 'vue-router'

import Home from '@/layouts/Home'
import FAQ from '@/layouts/FAQ'
import OpenSource from '@/layouts/OpenSource'

import UserProfile from '@/layouts/User/Profile'
import UserLogin from '@/layouts/User/Login'
import UserRegister from '@/layouts/User/Register'
import UserCookie from '@/layouts/User/Cookie'

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
    },
    {
      path: '/user/profile',
      name: 'UserProfile',
      component: UserProfile
    },
    {
      path: '/user/login',
      name: 'UserLogin',
      component: UserLogin
    },
    {
      path: '/user/register',
      name: 'UserRegister',
      component: UserRegister
    },
    {
      path: '/user/cookie',
      name: 'UserCookie',
      component: UserCookie
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
