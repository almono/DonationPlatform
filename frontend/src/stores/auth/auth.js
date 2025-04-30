import { defineStore } from 'pinia';
import api from '../../api.js';
import router from '../../router';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null
  }),
  actions: {
    async login(credentials) {
      try {
        await api.get('/sanctum/csrf-cookie').then(() => {
          // CSRF cookie set, you can now make API calls
          console.log('CSRF token set');
        })
        .catch(error => {
          console.error('Error fetching CSRF token:', error);
        });
        
        const response = await api.post('/api/auth/login', credentials)

        if(response.status === 200) {
          this.token = response.data.accessToken
          api.defaults.headers.common["Authorization"] = `Bearer ${this.token}`
          await this.fetchUser()
          router.push({path: '/dashboard'})
        }

        return response
      } catch (err) {
        return err.response
      }
    },

    async register(data) {
      try {
        const response = await api.post('/api/auth/register', { ...data })
        this.user = response.data
        return response
      } catch (err) {
        this.user = null
        return err.response
      }
    },

    async fetchUser() {
      try {
        const response = await api.get('/api/user', { withCredentials: true })
        this.user = response.data
      } catch (err) {
        this.user = null
        return err.response
      }
    },

    async logout() {
      await api.post('/api/auth/logout')
      this.user = null
      this.token = null

      // Remove token from Axios
      delete api.defaults.headers.common["Authorization"]
      router.push({ path: '/'})
    },
  },
});
