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
      if (!isLoggingOut) {
        isLoggingOut = true
        const authStore = useAuthStore()
        
        // Usar clearAuth ao invés de modificar diretamente
        authStore.clearAuth()
        
        router.push({ name: 'login' }).finally(() => {
          isLoggingOut = false
        })
      }
    }
    return Promise.reject(error)
  }
)

export default api
