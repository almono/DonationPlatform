import { defineStore } from 'pinia'
import api from '../../api.js';

export const useSettingsStore = defineStore('settings', {
  state: () => ({
    settings: null,
  }),
  actions: {
    async getApplicationSettings() {
      try {
        const response = await api.get('/api/settings')
        this.settings = response.data
      } catch (error) {
        console.error('Failed to load settings: ', error)
      }
    },
    toggleRegistration(value) {
      this.settings.registration_enabled = value ? 1 : 0; // Convert to 1 (enabled) or 0 (disabled)
    },
    async updateApplicationSettings() {
      try {
        await api.put('/api/settings', this.settings)
      } catch (error) {
        console.error('Failed to load settings: ', error)
      }
    }
  }
})