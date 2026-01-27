<template>
  <div>
    <!-- Header with editorial hierarchy -->
    <div class="mb-12">
      <div class="flex items-end justify-between border-b-2 border-primary-100 dark:border-primary-900/30 pb-6">
        <div>
          <h1 class="text-display-sm font-display font-bold text-earth-900 dark:text-white mb-2">Dashboard</h1>
          <p class="text-lg text-sage-600 dark:text-gray-400 font-medium">Visão geral · Sistema de Locações</p>
        </div>
        <div class="hidden sm:flex items-center space-x-2 text-sm font-semibold text-sage-600">
          <div class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></div>
          <span>Atualizado agora</span>
        </div>
      </div>
    </div>

    <!-- Stats Grid - Asymmetric & Organic -->
    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-12">
      <div v-for="i in 4" :key="i" class="animate-pulse">
        <div class="bg-white/50 dark:bg-earth-800/50 rounded-3xl p-6 h-36"></div>
      </div>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-12">
      <!-- Card 1: Marcas - Primary accent -->
      <div class="stat-card group before:from-primary-500/10 before:to-transparent">
        <div class="flex items-start justify-between mb-4">
          <div>
            <p class="text-xs font-bold text-sage-600 dark:text-sage-400 uppercase tracking-wider mb-2">Marcas</p>
            <p class="text-4xl font-display font-bold text-earth-900 dark:text-white">{{ stats.totalMarcas }}</p>
          </div>
          <div class="stat-icon-wrapper bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/40 dark:to-primary-800/40 group">
            <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
          </div>
        </div>
        <div class="flex items-center text-xs font-semibold text-primary-600 dark:text-primary-400">
          <div class="w-1.5 h-1.5 bg-primary-500 rounded-full mr-2"></div>
          Cadastradas
        </div>
      </div>

      <!-- Card 2: Modelos - Sage accent -->
      <div class="stat-card group before:from-sage-500/10 before:to-transparent lg:mt-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <p class="text-xs font-bold text-sage-600 dark:text-sage-400 uppercase tracking-wider mb-2">Modelos</p>
            <p class="text-4xl font-display font-bold text-earth-900 dark:text-white">{{ stats.totalModelos }}</p>
          </div>
          <div class="stat-icon-wrapper bg-gradient-to-br from-sage-100 to-sage-200 dark:from-sage-900/40 dark:to-sage-800/40 group">
            <svg class="w-7 h-7 text-sage-600 dark:text-sage-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          </div>
        </div>
        <div class="flex items-center text-xs font-semibold text-sage-600 dark:text-sage-400">
          <div class="w-1.5 h-1.5 bg-sage-500 rounded-full mr-2"></div>
          Disponíveis
        </div>
      </div>

      <!-- Card 3: Carros - Emerald accent -->
      <div class="stat-card group before:from-emerald-500/10 before:to-transparent">
        <div class="flex items-start justify-between mb-4">
          <div>
            <p class="text-xs font-bold text-sage-600 dark:text-sage-400 uppercase tracking-wider mb-2">Carros</p>
            <p class="text-4xl font-display font-bold text-earth-900 dark:text-white">{{ stats.totalCarros }}</p>
          </div>
          <div class="stat-icon-wrapper bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/40 dark:to-emerald-800/40 group">
            <svg class="w-7 h-7 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
            </svg>
          </div>
        </div>
        <div class="flex items-center text-xs font-semibold text-emerald-600 dark:text-emerald-400">
          <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></div>
          Na Frota
        </div>
      </div>

      <!-- Card 4: Clientes - Earth accent -->
      <div class="stat-card group before:from-earth-500/10 before:to-transparent lg:mt-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <p class="text-xs font-bold text-sage-600 dark:text-sage-400 uppercase tracking-wider mb-2">Clientes</p>
            <p class="text-4xl font-display font-bold text-earth-900 dark:text-white">{{ stats.totalClientes }}</p>
          </div>
          <div class="stat-icon-wrapper bg-gradient-to-br from-earth-100 to-earth-200 dark:from-earth-700/40 dark:to-earth-600/40 group">
            <svg class="w-7 h-7 text-earth-600 dark:text-earth-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
          </div>
        </div>
        <div class="flex items-center text-xs font-semibold text-earth-600 dark:text-earth-400">
          <div class="w-1.5 h-1.5 bg-earth-500 rounded-full mr-2"></div>
          Cadastrados
        </div>
      </div>
    </div>

    <!-- Locações Grid - Visual interest with depth -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Locações Ativas -->
      <div class="card card-hover">
        <div class="flex items-start justify-between mb-6 pb-5 border-b-2 border-sage-100 dark:border-earth-700">
          <div>
            <h2 class="text-xl font-display font-bold text-earth-900 dark:text-white mb-1">Locações Ativas</h2>
            <p class="text-sm text-sage-600 dark:text-sage-400 font-medium">Em andamento</p>
          </div>
          <span class="px-4 py-2 text-base font-bold bg-gradient-to-br from-primary-500 to-primary-600 text-white rounded-2xl shadow-organic">
            {{ stats.locacoesAtivas }}
          </span>
        </div>
        <div class="text-center py-10">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/30 dark:to-primary-800/30 rounded-[28px] mb-5 animate-float">
            <svg class="w-10 h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
          </div>
          <p class="text-lg font-semibold text-sage-700 dark:text-sage-300">
            {{ stats.locacoesAtivas }} {{ stats.locacoesAtivas === 1 ? 'locação' : 'locações' }} ativa{{ stats.locacoesAtivas === 1 ? '' : 's' }}
          </p>
          <p class="text-sm text-sage-500 dark:text-sage-400 mt-1">Aguardando devolução</p>
        </div>
      </div>

      <!-- Locações Finalizadas -->
      <div class="card card-hover lg:mt-8">
        <div class="flex items-start justify-between mb-6 pb-5 border-b-2 border-sage-100 dark:border-earth-700">
          <div>
            <h2 class="text-xl font-display font-bold text-earth-900 dark:text-white mb-1">Locações Concluídas</h2>
            <p class="text-sm text-sage-600 dark:text-sage-400 font-medium">Finalizadas</p>
          </div>
          <span class="px-4 py-2 text-base font-bold bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl shadow-organic">
            {{ stats.locacoesFinalizadas }}
          </span>
        </div>
        <div class="text-center py-10">
          <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/30 dark:to-emerald-800/30 rounded-[28px] mb-5 animate-float" style="animation-delay: 0.5s;">
            <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <p class="text-lg font-semibold text-sage-700 dark:text-sage-300">
            {{ stats.locacoesFinalizadas }} {{ stats.locacoesFinalizadas === 1 ? 'locação' : 'locações' }} concluída{{ stats.locacoesFinalizadas === 1 ? '' : 's' }}
          </p>
          <p class="text-sm text-sage-500 dark:text-sage-400 mt-1">Total histórico</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'
import { showAlert } from '@/utils/alert'

const loading = ref(true)
const stats = ref({
  totalMarcas: 0,
  totalModelos: 0,
  totalCarros: 0,
  totalClientes: 0,
  locacoesAtivas: 0,
  locacoesFinalizadas: 0
})

const fetchStats = async () => {
  loading.value = true
  try {
    // Usar o novo endpoint de estatísticas do dashboard
    const response = await api.get('/dashboard/stats')
    const data = response.data.data

    stats.value = {
      totalMarcas: data.total_marcas || 0,
      totalModelos: data.total_modelos || 0,
      totalCarros: data.total_carros || 0,
      totalClientes: data.total_clientes || 0,
      locacoesAtivas: data.locacoes_ativas || 0,
      locacoesFinalizadas: data.locacoes_finalizadas || 0
    }
  } catch (error) {
    // Não exibir alerta para erro 401 (não autorizado), pois o interceptor já redireciona para login
    if (error.response?.status !== 401) {
      console.error('Erro ao carregar estatísticas:', error)
      showAlert.error('Erro ao carregar estatísticas do dashboard')
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchStats()
})
</script>
