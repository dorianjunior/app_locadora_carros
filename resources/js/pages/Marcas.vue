<template>
  <div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
      <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Marcas</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Gerencie as marcas de veículos</p>
      </div>
      <button @click="openModal()" class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nova Marca
      </button>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6">
      <input
        v-model="searchQuery"
        @input="searchMarcas"
        type="text"
        placeholder="Buscar marcas..."
        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500"
      />
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-900/50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Nome
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Imagem
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                Ações
              </th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <tr v-if="loading">
              <td colspan="3" class="px-6 py-12 text-center">
                <div class="flex items-center justify-center">
                  <svg class="animate-spin h-8 w-8 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                </div>
              </td>
            </tr>
            <tr v-else-if="marcas.length === 0">
              <td colspan="3" class="px-6 py-12 text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Nenhuma marca cadastrada</p>
              </td>
            </tr>
            <tr v-else v-for="marca in marcas" :key="marca.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ marca.nome }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <img v-if="marca.imagem" :src="`/storage/${marca.imagem}`" alt="" class="w-10 h-10 rounded object-cover">
                <span v-else class="text-sm text-gray-400 dark:text-gray-500">Sem imagem</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                <button @click="openModal(marca)" class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300">
                  Editar
                </button>
                <button @click="deleteMarca(marca.id)" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                  Excluir
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <Modal v-model="showModal" :title="editingMarca ? 'Editar Marca' : 'Nova Marca'">
      <form @submit.prevent="saveMarca" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
          <input
            v-model="form.nome"
            type="text"
            required
            class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            placeholder="Nome da marca"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Imagem (URL)</label>
          <input
            v-model="form.imagem"
            type="text"
            class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            placeholder="URL da imagem"
          />
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

const loading = ref(false)
const saving = ref(false)
const marcas = ref([])
const showModal = ref(false)
const editingMarca = ref(null)
const searchQuery = ref('')
let searchTimeout = null

const form = ref({
  nome: '',
  imagem: ''
})

const fetchMarcas = async () => {
  loading.value = true
  try {
    const token = localStorage.getItem('token')
    const headers = { Authorization: `Bearer ${token}` }

    let url = '/api/v1/marca'
    if (searchQuery.value) {
      url += `?filtro=nome:like:%${searchQuery.value}%`
    }

    const response = await axios.get(url, { headers })
    marcas.value = response.data
  } catch (error) {
    alert('Erro ao carregar marcas')
  } finally {
    loading.value = false
  }
}

const searchMarcas = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchMarcas()
  }, 300)
}

const openModal = (marca = null) => {
  editingMarca.value = marca
  if (marca) {
    form.value = {
      nome: marca.nome,
      imagem: marca.imagem || ''
    }
  } else {
    form.value = {
      nome: '',
      imagem: ''
    }
  }
  showModal.value = true
}

const saveMarca = async () => {
  saving.value = true
  try {
    const token = localStorage.getItem('token')
    const headers = { Authorization: `Bearer ${token}` }

    if (editingMarca.value) {
      await axios.put(`/api/v1/marca/${editingMarca.value.id}`, form.value, { headers })
    } else {
      await axios.post('/api/v1/marca', form.value, { headers })
    }

    showModal.value = false
    await fetchMarcas()
  } catch (error) {
    alert(error.response?.data?.message || 'Erro ao salvar marca')
  } finally {
    saving.value = false
  }
}

const deleteMarca = async (id) => {
  if (!confirm('Deseja realmente excluir esta marca?')) return

  try {
    const token = localStorage.getItem('token')
    const headers = { Authorization: `Bearer ${token}` }

    await axios.delete(`/api/v1/marca/${id}`, { headers })
    await fetchMarcas()
  } catch (error) {
    alert(error.response?.data?.message || 'Erro ao excluir marca')
  }
}

onMounted(() => {
  fetchMarcas()
})
</script>
