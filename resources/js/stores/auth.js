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
        this.token = response.data.token
        localStorage.setItem('token', this.token)
        await this.fetchUser()
        return true
      } catch (error) {
        this.error = error.response?.data?.message || 'Erro ao fazer login'
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
        this.user = response.data
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
        // Silent error
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
          // Silent error
        }
      }
    }
  }
})
