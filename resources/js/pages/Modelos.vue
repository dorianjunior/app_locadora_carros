<template>
  <div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
      <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modelos</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Gerencie os modelos de veículos</p>
      </div>
      <button @click="openModal()" class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Novo Modelo
      </button>
    </div>

    <!-- Search -->
    <div class="mb-6">
      <input
        v-model="searchQuery"
        @input="searchModelos"
        type="text"
        placeholder="Buscar modelos..."
        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500"
      />
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-900/50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nome</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Marca</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Imagem</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Portas</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lugares</th>
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
            <tr v-else-if="modelos.length === 0">
              <td colspan="6" class="px-6 py-12 text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">Nenhum modelo cadastrado</p>
              </td>
            </tr>
            <tr v-else v-for="modelo in modelos" :key="modelo.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ modelo.nome }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ modelo.marca?.nome || 'N/A' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <img v-if="modelo.imagem" :src="`/storage/${modelo.imagem}`" alt="" class="w-10 h-10 rounded object-cover">
                <span v-else class="text-sm text-gray-400 dark:text-gray-500">Sem imagem</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ modelo.numero_portas }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ modelo.lugares }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                <button @click="openModal(modelo)" class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300">Editar</button>
                <button @click="deleteModelo(modelo.id)" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Excluir</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700 dark:text-gray-400">
            Mostrando <span class="font-medium">{{ pagination.from }}</span> a <span class="font-medium">{{ pagination.to }}</span> de <span class="font-medium">{{ pagination.total }}</span> modelos
          </div>
          <div class="flex items-center space-x-2">
            <button
              @click="fetchModelos(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-3 py-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
              Anterior
            </button>
            <span class="px-3 py-1 text-sm text-gray-700 dark:text-gray-300">
              Página {{ pagination.current_page }} de {{ pagination.last_page }}
            </span>
            <button
              @click="fetchModelos(pagination.current_page + 1)"
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
    <Modal v-model="showModal" :title="editingModelo ? 'Editar Modelo' : 'Novo Modelo'">
      <form @submit.prevent="saveModelo" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marca</label>
          <select
            v-model="form.marca_id"
            required
            class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
          >
            <option value="">Selecione uma marca</option>
            <option v-for="marca in marcas" :key="marca.id" :value="marca.id">{{ marca.nome }}</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
          <input
            v-model="form.nome"
            type="text"
            required
            class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            placeholder="Nome do modelo"
          />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Portas</label>
            <input
              v-model.number="form.numero_portas"
              type="number"
              required
              min="2"
              max="5"
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lugares</label>
            <input
              v-model.number="form.numero_lugares"
              type="number"
              required
              min="2"
              max="9"
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Air Bag</label>
            <select
              v-model="form.air_bag"
              required
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            >
              <option value="true">Sim</option>
              <option value="false">Não</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ABS</label>
            <select
              v-model="form.abs"
              required
              class="w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500"
            >
              <option value="true">Sim</option>
              <option value="false">Não</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Imagem</label>
          <div class="space-y-3">
            <div v-if="imagePreview" class="relative inline-block">
              <img :src="imagePreview" alt="Preview" class="w-32 h-32 rounded-lg object-cover border-2 border-gray-300 dark:border-gray-600">
              <button
                @click="removeImage"
                type="button"
                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
            <input
              @change="handleImageUpload"
              ref="fileInput"
              type="file"
              accept="image/png,image/jpeg,image/jpg,image/gif,image/webp"
              class="block w-full text-sm text-gray-900 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:bg-primary-600 file:text-white hover:file:bg-primary-700 file:cursor-pointer"
            />
            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG, GIF ou WebP até 2MB</p>
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
import api from '@/services/api'
import Modal from '@/components/Modal.vue'
import { showAlert } from '@/utils/alert'

const loading = ref(false)
const saving = ref(false)
const modelos = ref([])
const marcas = ref([])
const pagination = ref({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
  from: 0,
  to: 0
})
const showModal = ref(false)
const editingModelo = ref(null)
const searchQuery = ref('')
const imagePreview = ref(null)
const fileInput = ref(null)
const selectedFile = ref(null)
let searchTimeout = null

const form = ref({
  marca_id: '',
  nome: '',
  imagem: '',
  numero_portas: 4,
  numero_lugares: 5,
  air_bag: 'true',
  abs: 'true'
})

const fetchMarcas = async () => {
  try {
    const response = await api.get('/marca/all')
    // Novo formato: {success, message, data: [...]}
    marcas.value = response.data.data || []
  } catch (error) {
    marcas.value = []
  }
}

const fetchModelos = async (page = 1) => {
  loading.value = true
  try {
    let url = `/modelo?page=${page}&atributos_marca=id,nome`
    if (searchQuery.value) {
      url += `&filtro=nome:like:%${searchQuery.value}%`
    }

    const response = await api.get(url)
    // Novo formato: {success, message, data: {current_page, data: [...], ...}}
    const paginatedData = response.data.data

    modelos.value = paginatedData.data || []
    pagination.value = {
      current_page: paginatedData.current_page,
      last_page: paginatedData.last_page,
      per_page: paginatedData.per_page,
      total: paginatedData.total,
      from: paginatedData.from || 0,
      to: paginatedData.to || 0
    }
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao carregar modelos')
    modelos.value = []
  } finally {
    loading.value = false
  }
}

const searchModelos = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchModelos()
  }, 300)
}

const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    if (file.size > 2 * 1024 * 1024) {
      showAlert.error('A imagem deve ter no máximo 2MB')
      return
    }
    selectedFile.value = file
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const removeImage = () => {
  selectedFile.value = null
  imagePreview.value = null
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const openModal = (modelo = null) => {
  editingModelo.value = modelo
  if (modelo) {
    form.value = {
      marca_id: modelo.marca_id,
      nome: modelo.nome,
      imagem: modelo.imagem || '',
      numero_portas: modelo.numero_portas,
      numero_lugares: modelo.lugares,
      air_bag: modelo.air_bag ? 'true' : 'false',
      abs: modelo.abs ? 'true' : 'false'
    }
    if (modelo.imagem) {
      imagePreview.value = `/storage/${modelo.imagem}`
    }
  } else {
    form.value = {
      marca_id: '',
      nome: '',
      imagem: '',
      numero_portas: 4,
      numero_lugares: 5,
      air_bag: 'true',
      abs: 'true'
    }
    imagePreview.value = null
  }
  selectedFile.value = null
  showModal.value = true
}

const saveModelo = async () => {
  saving.value = true
  try {
    const formData = new FormData()
    formData.append('marca_id', form.value.marca_id)
    formData.append('nome', form.value.nome)
    formData.append('numero_portas', form.value.numero_portas)
    formData.append('lugares', form.value.numero_lugares)
    formData.append('air_bag', form.value.air_bag === 'true' ? '1' : '0')
    formData.append('abs', form.value.abs === 'true' ? '1' : '0')

    if (selectedFile.value) {
      formData.append('imagem', selectedFile.value)
    }

    const config = {
      headers: { 'Content-Type': 'multipart/form-data' }
    }

    if (editingModelo.value) {
      formData.append('_method', 'PUT')
      await api.post(`/modelo/${editingModelo.value.id}`, formData, config)
    } else {
      await api.post('/modelo', formData, config)
    }

    showModal.value = false
    removeImage()
    await fetchModelos(pagination.value.current_page)
    showAlert.toast.success(editingModelo.value ? 'Modelo atualizado com sucesso!' : 'Modelo criado com sucesso!')
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao salvar modelo')
  } finally {
    saving.value = false
  }
}

const deleteModelo = async (id) => {
  const result = await showAlert.confirm('Esta ação não poderá ser desfeita!', 'Deseja excluir este modelo?')
  if (!result.isConfirmed) return

  try {
    await api.delete(`/modelo/${id}`)
    await fetchModelos()
    showAlert.toast.success('Modelo excluído com sucesso!')
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao excluir modelo')
  }
}

onMounted(() => {
  fetchMarcas()
  fetchModelos()
})
</script>
