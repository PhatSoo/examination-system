import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'client',
      component: import('@/pages/ClientPage.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: import('@/pages/LoginPage.vue')
    },
    {
      path: '/signup',
      name: 'signup',
      component: import('@/pages/SignupPage.vue')
    }
  ]
})

export default router
