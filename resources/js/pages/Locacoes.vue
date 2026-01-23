<template>
  <div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
      <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Locações</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Gerencie as locações de veículos</p>
      </div>
      <button @click="openModal()" class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nova Locação
      </button>
    </div>

    <!-- Search -->
    <div class="mb-6">
      <input
        v-model="searchQuery"
        @input="searchLocacoes"
        type="text"
        placeholder="Buscar locações..."
        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500"
      />
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-900/50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cliente</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Carro</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Período</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <tr v-if="loading">
              <td colspan="6" class="px-6 py-12 text-center">
                <div class="flex items-center justify-center">
                  <svg class="animate-spin h-8 w-8 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                </div>
              </td>
            </tr>
            <tr v-else-if="locacoes.length === 0">
              <td colspan="6" class="px-6 py-12 text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Nenhuma locação cadastrada</p>
              </td>
            </tr>
            <tr v-else v-for="locacao in locacoes" :key="locacao.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ locacao.cliente?.nome || 'N/A' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 dark:text-white">{{ locacao.carro?.placa || 'N/A' }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ locacao.carro?.modelo?.nome || '' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 dark:text-white">{{ formatDate(locacao.data_inicio_periodo) }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">até {{ formatDate(locacao.data_final_previsto_periodo) }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 dark:text-white">R$ {{ formatMoney(locacao.valor_diaria) }}/dia</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="locacao.data_final_realizado_periodo" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                  Finalizada
                </span>
                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                  Em andamento
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                <button @click="openModal(locacao)" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</button>
                <button @click="deleteLocacao(locacao.id)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Excluir</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700 dark:text-gray-400">
            Mostrando <span class="font-medium">{{ pagination.from }}</span> a <span class="font-medium">{{ pagination.to }}</span> de <span class="font-medium">{{ pagination.total }}</span> locações
          </div>
          <div class="flex items-center space-x-2">
            <button
              @click="fetchLocacoes(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
              Anterior
            </button>
            <span class="px-3 py-1 text-sm text-gray-700 dark:text-gray-300">
              Página {{ pagination.current_page }} de {{ pagination.last_page }}
            </span>
            <button
              @click="fetchLocacoes(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
              Próxima
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <Modal v-model="showModal" :title="editingLocacao ? 'Editar Locação' : 'Nova Locação'">
      <form @submit.prevent="saveLocacao" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cliente</label>
            <select
              v-model="form.cliente_id"
              required
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            >
              <option value="">Selecione um cliente</option>
              <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">{{ cliente.nome }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Carro</label>
            <select
              v-model="form.carro_id"
              required
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            >
              <option value="">Selecione um carro</option>
              <option v-for="carro in carros" :key="carro.id" :value="carro.id">
                {{ carro.placa }} - {{ carro.modelo?.nome }}
              </option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Início</label>
            <input
              v-model="form.data_inicio_periodo"
              type="date"
              required
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Final Prevista</label>
            <input
              v-model="form.data_final_previsto_periodo"
              type="date"
              required
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor Diária</label>
            <input
              v-model="form.valor_diaria"
              type="number"
              step="0.01"
              required
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
              placeholder="0.00"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">KM Inicial</label>
            <input
              v-model="form.km_inicial"
              type="number"
              required
              min="0"
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
              placeholder="0"
            />
          </div>
        </div>

        <div v-if="editingLocacao" class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Final Realizada</label>
            <input
              v-model="form.data_final_realizado_periodo"
              type="date"
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">KM Final</label>
            <input
              v-model="form.km_final"
              type="number"
              min="0"
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
              placeholder="0"
            />
          </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
          <button
            type="button"
            @click="showModal = false"
            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors"
          >
            Cancelar
          </button>
          <button
            type="submit"
            :disabled="saving"
            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ saving ? 'Salvando...' : 'Salvar' }}
          </button>
        </div>
      </form>
    </Modal>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Modal from '@/components/Modal.vue'
import { showAlert } from '@/utils/alert'

const loading = ref(false)
const saving = ref(false)
const locacoes = ref([])
const clientes = ref([])
const carros = ref([])
const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
  from: 0,
  to: 0
})
const showModal = ref(false)
const editingLocacao = ref(null)
const searchQuery = ref('')
let searchTimeout = null

const form = ref({
  cliente_id: '',
  carro_id: '',
  data_inicio_periodo: '',
  data_final_previsto_periodo: '',
  data_final_realizado_periodo: '',
  valor_diaria: '',
  km_inicial: 0,
  km_final: 0
})

const formatDate = (date) => {
  if (!date) return ''
  return new Date(date).toLocaleDateString('pt-BR')
}

const formatMoney = (value) => {
  return new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(value)
}

const fetchClientes = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get('/api/v1/cliente?atributos=id,nome', {
      headers: { Authorization: `Bearer ${token}` }
    })
    clientes.value = response.data.data || []
  } catch (error) {
    clientes.value = []
  }
}

const fetchCarros = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get('/api/v1/carro?atributos=id,placa,modelo_id&atributos_modelo=id,nome', {
      headers: { Authorization: `Bearer ${token}` }
    })
    carros.value = response.data.data || []
  } catch (error) {
    carros.value = []
  }
}

const fetchLocacoes = async (page = 1) => {
  loading.value = true
  try {
    const token = localStorage.getItem('token')
    const headers = { Authorization: `Bearer ${token}` }

    let url = `/api/v1/locacao?page=${page}&atributos_cliente=id,nome&atributos_carro=id,placa,modelo_id&atributos_modelo=id,nome`

    const response = await axios.get(url, { headers })
    locacoes.value = response.data.data || []
    pagination.value = {
      current_page: response.data.current_page,
      last_page: response.data.last_page,
      per_page: response.data.per_page,
      total: response.data.total,
      from: response.data.from || 0,
      to: response.data.to || 0
    }
  } catch (error) {
    showAlert.error('Erro ao carregar locações')
    locacoes.value = []
  } finally {
    loading.value = false
  }
}

const searchLocacoes = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchLocacoes()
  }, 300)
}

const openModal = (locacao = null) => {
  editingLocacao.value = locacao
  if (locacao) {
    form.value = {
      cliente_id: locacao.cliente_id,
      carro_id: locacao.carro_id,
      data_inicio_periodo: locacao.data_inicio_periodo,
      data_final_previsto_periodo: locacao.data_final_previsto_periodo,
      data_final_realizado_periodo: locacao.data_final_realizado_periodo || '',
      valor_diaria: locacao.valor_diaria,
      km_inicial: locacao.km_inicial,
      km_final: locacao.km_final || 0
    }
  } else {
    form.value = {
      cliente_id: '',
      carro_id: '',
      data_inicio_periodo: '',
      data_final_previsto_periodo: '',
      data_final_realizado_periodo: '',
      valor_diaria: '',
      km_inicial: 0,
      km_final: 0
    }
  }
  showModal.value = true
}

const saveLocacao = async () => {
  saving.value = true
  try {
    const token = localStorage.getItem('token')
    const headers = { Authorization: `Bearer ${token}` }

    const data = {
      cliente_id: form.value.cliente_id,
      carro_id: form.value.carro_id,
      data_inicio_periodo: form.value.data_inicio_periodo,
      data_final_previsto_periodo: form.value.data_final_previsto_periodo,
      valor_diaria: form.value.valor_diaria,
      km_inicial: form.value.km_inicial
    }

    if (form.value.data_final_realizado_periodo) {
      data.data_final_realizado_periodo = form.value.data_final_realizado_periodo
    }

    if (form.value.km_final) {
      data.km_final = form.value.km_final
    }

    if (editingLocacao.value) {
      await axios.put(`/api/v1/locacao/${editingLocacao.value.id}`, data, { headers })
    } else {
      await axios.post('/api/v1/locacao', data, { headers })
    }

    showModal.value = false
    await fetchLocacoes(pagination.value.current_page)
    showAlert.toast.success(editingLocacao.value ? 'Locação atualizada com sucesso!' : 'Locação criada com sucesso!')
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao salvar locação')
  } finally {
    saving.value = false
  }
}

const deleteLocacao = async (id) => {
  const result = await showAlert.confirm('Esta ação não poderá ser desfeita!', 'Deseja excluir esta locação?')
  if (!result.isConfirmed) return

  try {
    const token = localStorage.getItem('token')
    const headers = { Authorization: `Bearer ${token}` }

    await axios.delete(`/api/v1/locacao/${id}`, { headers })
    await fetchLocacoes()
    showAlert.toast.success('Locação excluída com sucesso!')
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao excluir locação')
  }
}

onMounted(() => {
  fetchClientes()
  fetchCarros()
  fetchLocacoes()
})
</script>
