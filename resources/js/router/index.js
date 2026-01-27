import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

// Layouts
import AuthLayout from '@/layouts/AuthLayout.vue'
import AppLayout from '@/layouts/AppLayout.vue'

// Pages
import Login from '@/pages/Login.vue'
import Dashboard from '@/pages/Dashboard.vue'
import Marcas from '@/pages/Marcas.vue'
import Modelos from '@/pages/Modelos.vue'
import Carros from '@/pages/Carros.vue'
import Clientes from '@/pages/Clientes.vue'
import Locacoes from '@/pages/Locacoes.vue'

const routes = [
  {
    path: '/login',
    component: AuthLayout,
    children: [
      {
        path: '',
        name: 'login',
        component: Login,
        meta: { guest: true }
      }
    ]
  },
  {
    path: '/',
    component: AppLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'dashboard',
        component: Dashboard
      },
      {
        path: 'marcas',
        name: 'marcas',
        component: Marcas
      },
      {
        path: 'modelos',
        name: 'modelos',
        component: Modelos
      },
      {
        path: 'carros',
        name: 'carros',
        component: Carros
      },
      {
        path: 'clientes',
        name: 'clientes',
        component: Clientes
      },
      {
        path: 'locacoes',
        name: 'locacoes',
        component: Locacoes
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()

  // Se a rota requer autenticação e há um token, verificar se ainda é válido
  if (to.meta.requiresAuth && authStore.token && !authStore.user) {
    try {
      await authStore.checkAuth()
    } catch (error) {
      // Se falhar, redireciona para login
      return next({ name: 'login' })
    }
  }

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: 'login' })
  } else if (to.meta.guest && authStore.isAuthenticated) {
    next({ name: 'dashboard' })
  } else {
    next()
  }
})

export default router
