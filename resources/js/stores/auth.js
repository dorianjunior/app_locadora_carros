import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    loading: false,
    error: null,
    isCheckingAuth: false // Flag para evitar múltiplas chamadas
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
    currentUser: (state) => state.user
  },

  actions: {
    async login(credentials) {
      this.loading = true
      this.error = null

      try {
        const response = await axios.post('/api/login', credentials)

        if (response.data.success) {
          this.token = response.data.data.access_token
          this.user = response.data.data.user
          localStorage.setItem('token', this.token)
          return true
        } else {
          throw new Error(response.data.message || 'Erro ao fazer login')
        }
      } catch (error) {
        this.error = error.response?.data?.message || error.message || 'Erro ao fazer login'
        throw error
      } finally {
        this.loading = false
      }
    },

    async fetchUser() {
      try {
        const response = await axios.get('/api/v1/me', {
          headers: { Authorization: `Bearer ${this.token}` }
        })

        if (response.data.success) {
          this.user = response.data.data
          return true
        } else {
          this.clearAuth()
          return false
        }
      } catch (error) {
        // Apenas limpar auth se for erro 401 (não autorizado)
        if (error.response?.status === 401) {
          this.clearAuth()
        }
        throw error
      }
    },

    clearAuth() {
      this.user = null
      this.token = null
      localStorage.removeItem('token')
    },

    async logout() {
      if (this.token) {
        try {
          await axios.post('/api/v1/logout', {}, {
            headers: { Authorization: `Bearer ${this.token}` }
          })
        } catch (error) {
        }
      }
      this.clearAuth()
    },

    async checkAuth() {
      if (this.user) {
        return true
      }

      if (this.isCheckingAuth) {
        return new Promise((resolve, reject) => {
          const interval = setInterval(() => {
            if (!this.isCheckingAuth) {
              clearInterval(interval)
              if (this.user) {
                resolve(true)
              } else {
                reject(new Error('Auth check failed'))
              }
            }
          }, 50)
        })
      }

      if (this.token) {
        this.isCheckingAuth = true
        try {
          await this.fetchUser()
          this.isCheckingAuth = false
          return true
        } catch (error) {
          this.isCheckingAuth = false
          throw error
        }
      }
      return false
    }
  }
})
