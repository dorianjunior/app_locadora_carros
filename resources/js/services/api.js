import axios from 'axios'
import router from '@/router'
import { useAuthStore } from '@/stores/auth'

const api = axios.create({
  baseURL: '/api/v1',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})


let isLoggingOut = false

api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

api.interceptors.response.use(
  (response) => {
    if (response.data && response.data.success === false) {
      return Promise.reject(response.data)
    }
    return response
  },
  (error) => {
    if (error.response?.status === 401) {
      // Evitar múltiplos logouts simultâneos
      if (!isLoggingOut) {
        isLoggingOut = true
        const authStore = useAuthStore()
        authStore.logout()

        // Pequeno delay para garantir que o logout complete antes de redirecionar
        setTimeout(() => {
          router.push({ name: 'login' })
          isLoggingOut = false
        }, 100)
      }
    }
    return Promise.reject(error)
  }
)

export default api
