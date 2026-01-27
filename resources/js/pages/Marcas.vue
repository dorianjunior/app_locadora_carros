<template>
  <div>
    <!-- Header with editorial hierarchy -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-10 gap-6 pb-6 border-b-2 border-primary-100 dark:border-primary-900/30">
      <div>
        <h1 class="text-display-sm font-display font-bold text-earth-900 dark:text-white mb-2">Marcas</h1>
        <p class="text-lg text-sage-600 dark:text-gray-400 font-medium">Gerencie as marcas de veículos</p>
      </div>
      <button @click="openModal()" class="btn btn-primary group">
        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Nova Marca
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
          @input="searchMarcas"
          type="text"
          placeholder="Buscar marcas..."
          class="input pl-12"
        />
      </div>
    </div>

    <!-- Table with organic design -->
    <div class="card overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y-2 divide-sage-100 dark:divide-earth-700">
          <thead class="bg-gradient-to-r from-sage-50 to-transparent dark:from-earth-900/30 dark:to-transparent">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-bold text-sage-800 dark:text-sage-300 uppercase tracking-wider">
                Nome
              </th>
              <th class="px-6 py-4 text-left text-xs font-bold text-sage-800 dark:text-sage-300 uppercase tracking-wider">
                Imagem
              </th>
              <th class="px-6 py-4 text-right text-xs font-bold text-sage-800 dark:text-sage-300 uppercase tracking-wider">
                Ações
              </th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-earth-800 divide-y divide-sage-100 dark:divide-earth-700">
            <tr v-if="loading">
              <td colspan="3" class="px-6 py-16 text-center">
                <div class="flex items-center justify-center">
                  <svg class="animate-spin h-8 w-8 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                </div>
              </td>
            </tr>
            <tr v-else-if="marcas.length === 0">
              <td colspan="3" class="px-6 py-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-sage-100 to-sage-200 dark:from-sage-900/30 dark:to-sage-800/30 rounded-[28px] mb-5">
                  <svg class="w-10 h-10 text-sage-500 dark:text-sage-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                  </svg>
                </div>
                <p class="text-base font-semibold text-sage-600 dark:text-sage-400">Nenhuma marca cadastrada</p>
                <p class="text-sm text-sage-500 dark:text-sage-500 mt-1">Clique em "Nova Marca" para começar</p>
              </td>
            </tr>
            <tr v-else v-for="marca in marcas" :key="marca.id" class="hover:bg-sage-50/50 dark:hover:bg-earth-700/30 transition-all duration-200 group">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-semibold text-earth-900 dark:text-white">{{ marca.nome }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <img v-if="marca.imagem" :src="`/storage/${marca.imagem}`" alt="" class="w-12 h-12 rounded-2xl object-cover shadow-sm group-hover:scale-105 transition-transform duration-200">
                <span v-else class="text-sm text-sage-500 dark:text-sage-500">Sem imagem</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold space-x-4">
                <button @click="openModal(marca)" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                  Editar
                </button>
                <button @click="deleteMarca(marca.id)" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                  Excluir
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-5 bg-gradient-to-r from-sage-50 to-transparent dark:from-earth-900/30 dark:to-transparent border-t-2 border-sage-100 dark:border-earth-700">
        <div class="flex items-center justify-between">
          <div class="text-sm font-medium text-sage-700 dark:text-sage-300">
            Mostrando <span class="font-bold text-primary-600 dark:text-primary-400">{{ pagination.from }}</span> a <span class="font-bold text-primary-600 dark:text-primary-400">{{ pagination.to }}</span> de <span class="font-bold text-primary-600 dark:text-primary-400">{{ pagination.total }}</span> marcas
          </div>
          <div class="flex items-center space-x-2">
            <button
              @click="fetchMarcas(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="px-4 py-2 bg-white dark:bg-earth-800 border-2 border-sage-200 dark:border-earth-600 rounded-xl text-sm font-semibold text-sage-700 dark:text-sage-300 hover:bg-sage-50 hover:border-primary-300 dark:hover:bg-earth-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-200"
            >
              Anterior
            </button>
            <span class="px-4 py-2 text-sm font-bold text-earth-900 dark:text-white">
              {{ pagination.current_page }} <span class="text-sage-500 dark:text-sage-500">de</span> {{ pagination.last_page }}
            </span>
            <button
              @click="fetchMarcas(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="px-4 py-2 bg-white dark:bg-earth-800 border-2 border-sage-200 dark:border-earth-600 rounded-xl text-sm font-semibold text-sage-700 dark:text-sage-300 hover:bg-sage-50 hover:border-primary-300 dark:hover:bg-earth-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-200"
            >
              Próxima
            </button>
          </div>
        </div>
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
const editingMarca = ref(null)
const searchQuery = ref('')
const imagePreview = ref(null)
const fileInput = ref(null)
const selectedFile = ref(null)
let searchTimeout = null

const form = ref({
  nome: '',
  imagem: ''
})

const fetchMarcas = async (page = 1) => {
  loading.value = true
  try {
    let url = `/marca?page=${page}`
    if (searchQuery.value) {
      url += `&filtro=nome:like:%${searchQuery.value}%`
    }

    const response = await api.get(url)
    // Novo formato: {success, message, data: {current_page, data: [...], ...}}
    const paginatedData = response.data.data

    marcas.value = paginatedData.data || []
    pagination.value = {
      current_page: paginatedData.current_page,
      last_page: paginatedData.last_page,
      per_page: paginatedData.per_page,
      total: paginatedData.total,
      from: paginatedData.from || 0,
      to: paginatedData.to || 0
    }
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao carregar marcas')
    marcas.value = []
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

const openModal = (marca = null) => {
  editingMarca.value = marca
  if (marca) {
    form.value = {
      nome: marca.nome,
      imagem: marca.imagem || ''
    }
    if (marca.imagem) {
      imagePreview.value = `/storage/${marca.imagem}`
    }
  } else {
    form.value = {
      nome: '',
      imagem: ''
    }
    imagePreview.value = null
  }
  selectedFile.value = null
  showModal.value = true
}

const saveMarca = async () => {
  saving.value = true
  try {
    const formData = new FormData()
    formData.append('nome', form.value.nome)

    if (selectedFile.value) {
      formData.append('imagem', selectedFile.value)
    }

    const config = {
      headers: { 'Content-Type': 'multipart/form-data' }
    }

    if (editingMarca.value) {
      formData.append('_method', 'PUT')
      await api.post(`/marca/${editingMarca.value.id}`, formData, config)
    } else {
      await api.post('/marca', formData, config)
    }

    showModal.value = false
    removeImage()
    await fetchMarcas(pagination.value.current_page)
    showAlert.toast.success(editingMarca.value ? 'Marca atualizada com sucesso!' : 'Marca criada com sucesso!')
  } catch (error) {
    if (error.response?.data?.errors) {
      const errors = Object.values(error.response.data.errors).flat()
      showAlert.error(errors.join('\n'), 'Erro de validação')
    } else {
      showAlert.error(error.response?.data?.message || 'Erro ao salvar marca')
    }
  } finally {
    saving.value = false
  }
}

const deleteMarca = async (id) => {
  const result = await showAlert.confirm('Esta ação não poderá ser desfeita!', 'Deseja excluir esta marca?')
  if (!result.isConfirmed) return

  try {
    await api.delete(`/marca/${id}`)
    await fetchMarcas()
    showAlert.toast.success('Marca excluída com sucesso!')
  } catch (error) {
    showAlert.error(error.response?.data?.message || 'Erro ao excluir marca')
  }
}

onMounted(() => {
  fetchMarcas()
})
</script>
