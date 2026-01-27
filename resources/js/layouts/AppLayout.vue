<template>
  <div class="min-h-screen bg-sage-50 dark:bg-dark-900 transition-colors">
    <aside
      class="fixed top-0 left-0 z-40 w-72 h-screen transition-transform lg:translate-x-0"
      :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
    >
      <div class="h-full px-5 py-6 overflow-y-auto bg-gradient-to-b from-white to-sage-50/50 dark:from-dark-800 dark:to-dark-900 border-r-2 border-primary-100/30 dark:border-dark-700 backdrop-blur-sm">
        <div class="mb-10 px-2">
          <div class="flex items-center space-x-4">
            <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-3xl flex items-center justify-center shadow-organic animate-float relative overflow-hidden">
              <div class="absolute inset-0 bg-white/20 animate-pulse-soft"></div>
              <svg class="w-8 h-8 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
              </svg>
            </div>
            <div>
              <span class="text-2xl font-display font-bold text-earth-900 dark:text-white tracking-tight">LocaCar</span>
              <p class="text-xs text-sage-600 dark:text-sage-400 font-medium tracking-wider uppercase mt-0.5">Sistema</p>
            </div>
          </div>
        </div>

        <nav class="space-y-1.5">
          <router-link
            v-for="item in navigation"
            :key="item.name"
            :to="item.to"
            class="flex items-center px-4 py-3.5 text-sm font-semibold rounded-2xl transition-all duration-300 group relative overflow-hidden"
            :class="isActive(item.to)
              ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-organic'
              : 'text-sage-700 dark:text-gray-300 hover:bg-sage-100 dark:hover:bg-dark-700 hover:translate-x-1'"
          >
            <div
              v-if="isActive(item.to)"
              class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
            ></div>
            <component
              :is="item.icon"
              class="w-5 h-5 mr-3.5 relative z-10 transition-transform duration-300"
              :class="isActive(item.to) ? 'scale-110' : 'group-hover:scale-110 group-hover:rotate-3'"
            />
            <span class="relative z-10">{{ item.name }}</span>
          </router-link>
        </nav>

        <div class="mt-12 px-4">
          <div class="bg-gradient-to-br from-primary-50 to-sage-50 dark:from-dark-700 dark:to-dark-800 rounded-3xl p-5 border border-primary-100/50 dark:border-dark-600 relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-24 h-24 bg-primary-400/10 rounded-full blur-2xl"></div>
            <p class="text-xs font-semibold text-sage-800 dark:text-gray-300 mb-1 relative z-10">Sistema v2.0</p>
            <p class="text-xs text-sage-600 dark:text-gray-400 relative z-10">Gestão inteligente</p>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-72">
      <header class="bg-white/80 dark:bg-dark-800/90 backdrop-blur-xl border-b-2 border-sage-100 dark:border-dark-700 sticky top-0 z-30 shadow-sm">
        <div class="px-6 py-5 sm:px-8 lg:px-10">
          <div class="flex items-center justify-between">
            <!-- Mobile menu button -->
            <button
              @click="sidebarOpen = !sidebarOpen"
              class="lg:hidden p-2.5 rounded-xl text-sage-700 dark:text-sage-300 hover:bg-sage-100 dark:hover:bg-earth-700 transition-all duration-200 hover:scale-105 active:scale-95"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
            </button>

            <div class="flex-1 lg:flex-none"></div>

            <!-- User menu with visual interest -->
            <div class="flex items-center space-x-3">
              <!-- Theme Toggle -->
              <button
                @click="themeStore.toggleTheme()"
                class="p-2.5 rounded-xl text-sage-700 dark:text-gray-300 hover:bg-gradient-to-br hover:from-sage-100 hover:to-primary-50 dark:hover:from-dark-700 dark:hover:to-dark-600 transition-all duration-300 hover:scale-105 active:scale-95 group"
                :title="themeStore.isDark ? 'Modo Claro' : 'Modo Escuro'"
              >
                <svg v-if="themeStore.isDark" class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <svg v-else class="w-5 h-5 group-hover:-rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
              </button>

              <div class="text-right hidden sm:block pl-3 border-l-2 border-sage-200 dark:border-dark-600">
                <p class="text-sm font-semibold text-earth-900 dark:text-white">{{ user?.name }}</p>
                <p class="text-xs text-sage-600 dark:text-gray-400 font-medium">{{ user?.email }}</p>
              </div>

              <button
                @click="handleLogout"
                class="p-2.5 rounded-xl text-sage-700 dark:text-gray-300 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400 transition-all duration-300 hover:scale-105 active:scale-95 group"
                title="Sair"
              >
                <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </header>

      <main class="p-6 sm:p-8 lg:p-10 max-w-[1600px]">
        <router-view />
      </main>
    </div>

    <!-- Mobile sidebar overlay -->
    <div
      v-if="sidebarOpen"
      @click="sidebarOpen = false"
      class="fixed inset-0 bg-dark-900/70 backdrop-blur-sm z-30 lg:hidden transition-opacity duration-300"
    ></div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useThemeStore } from '@/stores/theme'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()
const themeStore = useThemeStore()

const sidebarOpen = ref(false)
const user = computed(() => authStore.user)

const navigation = [
  {
    name: 'Dashboard',
    to: '/',
    icon: 'DashboardIcon'
  },
  {
    name: 'Marcas',
    to: '/marcas',
    icon: 'TagIcon'
  },
  {
    name: 'Modelos',
    to: '/modelos',
    icon: 'CubeIcon'
  },
  {
    name: 'Carros',
    to: '/carros',
    icon: 'TruckIcon'
  },
  {
    name: 'Clientes',
    to: '/clientes',
    icon: 'UsersIcon'
  },
  {
    name: 'Locações',
    to: '/locacoes',
    icon: 'ClipboardListIcon'
  }
]

const isActive = (path) => {
  return route.path === path || route.path.startsWith(path + '/')
}

const handleLogout = async () => {
  await authStore.logout()
  router.push({ name: 'login' })
}

// Icons as simple components
const DashboardIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>`
}

const TagIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>`
}

const CubeIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>`
}

const TruckIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>`
}

const UsersIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`
}

const ClipboardListIcon = {
  template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>`
}
</script>
