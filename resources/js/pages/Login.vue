<template>
  <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Organic background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-bl from-primary-100/40 via-sage-100/30 to-transparent rounded-full blur-3xl animate-pulse-soft" style="transform: translate(30%, -30%);"></div>
      <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gradient-to-tr from-primary-200/30 via-earth-100/20 to-transparent rounded-full blur-3xl animate-pulse-soft" style="animation-delay: 1s; transform: translate(-30%, 30%);"></div>
    </div>

    <div class="max-w-md w-full relative z-10">
      <!-- Logo with visual impact - asymmetric placement -->
      <div class="mb-12">
        <div class="flex items-start space-x-5 mb-8">
          <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-[28px] flex items-center justify-center shadow-organic-lg transform -rotate-3 animate-float">
            <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-transparent rounded-[28px]"></div>
            <svg class="w-11 h-11 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
          </div>
          <div class="pt-2">
            <h1 class="text-4xl font-display font-bold text-earth-900 mb-1 tracking-tight">Bem-vindo</h1>
            <p class="text-base text-sage-600 font-medium">Sistema LocaCar</p>
          </div>
        </div>
        <p class="text-sage-700 text-lg font-medium pl-1">Entre para gerenciar suas locações</p>
      </div>

      <!-- Form with refined design -->
      <div class="card card-hover">
        <form @submit.prevent="handleLogin" class="space-y-6">
          <!-- Email -->
          <div>
            <label for="email" class="label">E-mail</label>
            <div class="relative group">
              <div class="absolute left-4 top-1/2 -translate-y-1/2 text-sage-400 group-focus-within:text-primary-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                </svg>
              </div>
              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                class="input pl-12"
                placeholder="seu@email.com"
                :disabled="loading"
              />
            </div>
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="label">Senha</label>
            <div class="relative group">
              <div class="absolute left-4 top-1/2 -translate-y-1/2 text-sage-400 group-focus-within:text-primary-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
              </div>
              <input
                id="password"
                v-model="form.password"
                type="password"
                required
                class="input pl-12"
                placeholder="••••••••"
                :disabled="loading"
              />
            </div>
          </div>

          <!-- Error Message -->
          <div
            v-if="error"
            class="bg-gradient-to-r from-red-50 to-red-50/50 border-2 border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm font-medium flex items-start space-x-3"
          >
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ error }}</span>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            class="w-full btn btn-primary py-4 flex items-center justify-center text-base font-semibold group"
            :disabled="loading"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ loading ? 'Entrando...' : 'Entrar no Sistema' }}</span>
            <svg v-if="!loading" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
          </button>
        </form>

        <!-- Decorative element -->
        <div class="mt-8 pt-6 border-t-2 border-sage-100 text-center">
          <p class="text-sm text-sage-600">
            <span class="font-medium">v2.0</span> · Sistema de Gestão
          </p>
        </div>
      </div>

      <!-- Footer info -->
      <div class="mt-8 text-center">
        <p class="text-sm text-sage-600">
          Acesso seguro com <span class="font-semibold text-primary-600">JWT</span>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = ref({
  email: '',
  password: ''
})

const loading = ref(false)
const error = ref(null)

const handleLogin = async () => {
  loading.value = true
  error.value = null

  try {
    await authStore.login(form.value)
    router.push({ name: 'dashboard' })
  } catch (err) {
    error.value = authStore.error || 'Erro ao fazer login. Verifique suas credenciais.'
  } finally {
    loading.value = false
  }
}
</script>
