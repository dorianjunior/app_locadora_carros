<template>
  <div>
    <!-- Header with editorial hierarchy -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-10 gap-6 pb-6 border-b-2 border-primary-100 dark:border-primary-900/30">
      <div>
        <h1 class="text-display-sm font-display font-bold text-earth-900 dark:text-white mb-2">Carros</h1>
        <p class="text-lg text-sage-600 dark:text-gray-400 font-medium">Gerencie a frota de veículos</p>
      </div>
      <button @click="openModal()" class="btn btn-primary group">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Novo Carro
      </button>
    </div>

    <!-- Search with refined design -->
    <div class="mb-8">
      <div class="relative group">
        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-sage-400 group-focus-within:text-primary-500 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
        <input
          v-model="searchQuery"
          @input="searchCarros"
          type="text"
          placeholder="Buscar carros..."
          class="input pl-12"
        />
      </div>
    </div>

    <!-- Table with organic design -->
    <div class="card overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-900/50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Placa</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Modelo</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Marca</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">KM</th>
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
            <tr v-else-if="carros.length === 0">
              <td colspan="6" class="px-6 py-12 text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Nenhum carro cadastrado</p>
              </td>
            </tr>
            <tr v-else v-for="carro in carros" :key="carro.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ carro.placa }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 dark:text-white">{{ carro.modelo?.nome || 'N/A' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-500 dark:text-gray-400">{{ carro.modelo?.marca?.nome || 'N/A' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 dark:text-white">{{ formatNumber(carro.km) }} km</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span v-if="carro.disponivel" class="px-3 py-1.5 inline-flex text-xs font-bold rounded-2xl bg-gradient-to-br from-primary-100 to-primary-200 text-primary-700 dark:from-primary-900/40 dark:to-primary-800/40 dark:text-primary-300 shadow-sm">
                  Disponível
                </span>
                <span v-else class="px-3 py-1.5 inline-flex text-xs font-bold rounded-2xl bg-gradient-to-br from-sage-100 to-sage-200 text-sage-700 dark:from-sage-900/40 dark:to-sage-800/40 dark:text-sage-300 shadow-sm">
                  Indisponível
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                <button @click="openModal(carro)" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</button>
                <button @click="deleteCarro(carro.id)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Excluir</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700 dark:text-gray-400">
            Mostrando <span class="font-medium">{{ pagination.from }}</span> a <span class="font-medium">{{ pagination.to }}</span> de <span class="font-medium">{{ pagination.total }}</span> carros
          </div>
          <div class="flex items-center space-x-2">
            <button
              @click="fetchCarros(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
              Anterior
            </button>
            <span class="px-3 py-1 text-sm text-gray-700 dark:text-gray-300">
              Página {{ pagination.current_page }} de {{ pagination.last_page }}
            </span>
            <button
              @click="fetchCarros(pagination.current_page + 1)"
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
    <Modal v-model="showModal" :title="editingCarro ? 'Editar Carro' : 'Novo Carro'">
      <form @submit.prevent="saveCarro" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Modelo</label>
          <select
            v-model="form.modelo_id"
            required
            class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
          >
            <option value="">Selecione um modelo</option>
            <option v-for="modelo in modelos" :key="modelo.id" :value="modelo.id">
              {{ modelo.marca?.nome }} - {{ modelo.nome }}
            </option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Placa</label>
          <input
            v-model="form.placa"
            type="text"
            required
            maxlength="10"
            class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            placeholder="ABC-1234"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quilometragem (KM)</label>
          <input
            v-model="form.km"
            type="number"
            required
            min="0"
            class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            placeholder="0"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select
            v-model="form.disponivel"
            required
            class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
          >
            <option value="1">Disponível</option>
            <option value="0">Indisponível</option>
          </select>
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
import api from '@/services/api'
import Modal from '@/components/Modal.vue'
import { showAlert } from '@/utils/alert'

const loading = ref(false)
const saving = ref(false)
const carros = ref([])
const modelos = ref([])
const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
  from: 0,
  to: 0
})
const showModal = ref(false)
const editingCarro = ref(null)
const searchQuery = ref('')
let searchTimeout = null

const form = ref({
  modelo_id: '',
  placa: '',
  disponivel: '1',
  km: 0
})

const formatNumber = (num) => {
  return new Intl.NumberFormat('pt-BR').format(num)
}

const fetchModelos = async () => {
  try {
    const response = await api.get('/modelo/all')
    // Novo formato: {success, message, data: [...]}
    modelos.value = response.data.data || []
  } catch (error) {
    modelos.value = []
  }
}

const fetchCarros = async (page = 1) => {
  loading.value = true
  try {
    let url = `/carro?page=${page}&atributos_modelo=id,nome,marca_id&atributos_marca=id,nome`
    if (searchQuery.value) {
      url += `&filtro=placa:like:%${searchQuery.value}%`
    }

    const response = await api.get(url)
    // Novo formato: {success, message, data: {current_page, data: [...], ...}}
    const paginatedData = response.data.data

    carros.value = paginatedData.data || []
    pagination.value = {
      current_page: paginatedData.current_page,
      last_page: paginatedData.last_page,
      per_page: paginatedData.per_page,
      total: paginatedData.total,
      from: paginatedData.from || 0,
      to: paginatedData.to || 0
    }
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao carregar carros')
    carros.value = []
  } finally {
    loading.value = false
  }
}

const searchCarros = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchCarros()
  }, 300)
}

const openModal = (carro = null) => {
  editingCarro.value = carro
  if (carro) {
    form.value = {
      modelo_id: carro.modelo_id,
      placa: carro.placa,
      disponivel: carro.disponivel ? '1' : '0',
      km: carro.km
    }
  } else {
    form.value = {
      modelo_id: '',
      placa: '',
      disponivel: '1',
      km: 0
    }
  }
  showModal.value = true
}

const saveCarro = async () => {
  saving.value = true
  try {
    const data = {
      modelo_id: form.value.modelo_id,
      placa: form.value.placa,
      disponivel: form.value.disponivel === '1' ? 1 : 0,
      km: form.value.km
    }

    if (editingCarro.value) {
      await api.put(`/carro/${editingCarro.value.id}`, data)
    } else {
      await api.post('/carro', data)
    }

    showModal.value = false
    await fetchCarros(pagination.value.current_page)
    showAlert.toast.success(editingCarro.value ? 'Carro atualizado com sucesso!' : 'Carro criado com sucesso!')
  } catch (error) {
    if (error.response?.data?.errors) {
      const errors = Object.values(error.response.data.errors).flat()
      showAlert.error(errors.join('\n'), 'Erro de validação')
    } else {
      showAlert.error(error.response?.data?.message || 'Erro ao salvar carro')
    }
  } finally {
    saving.value = false
  }
}

const deleteCarro = async (id) => {
  const result = await showAlert.confirm('Esta ação não poderá ser desfeita!', 'Deseja excluir este carro?')
  if (!result.isConfirmed) return

  try {
    await api.delete(`/carro/${id}`)
    await fetchCarros()
    showAlert.toast.success('Carro excluído com sucesso!')
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao excluir carro')
  }
}

onMounted(() => {
  fetchModelos()
  fetchCarros()
})
</script>
