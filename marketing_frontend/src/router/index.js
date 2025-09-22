import LoginComponent from '@/auth/login/LoginComponent.vue'
import { createRouter, createWebHistory } from 'vue-router'



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path:'/marketing/login',
      name:'marketingLogin',
      component: LoginComponent,
    }
  ],
})

export default router
