import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    loading: false,
    error: null
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
        } else {
          this.logout()
        }
      } catch (error) {
        this.logout()
      }
    },

    async logout() {
      try {
        await axios.post('/api/v1/logout', {}, {
          headers: { Authorization: `Bearer ${this.token}` }
        })
      } catch (error) {
        // Ignora erros no logout
      } finally {
        this.user = null
        this.token = null
        localStorage.removeItem('token')
      }
    },

    async checkAuth() {
      if (this.token) {
        try {
          await this.fetchUser()
        } catch (error) {
          // Ignora erros na verificação
        }
      }
    }
  }
})
