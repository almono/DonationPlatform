import { defineStore } from 'pinia';
import api from '../../api.js';

export const useDonationsStore = defineStore('donations', {
  state: () => ({
    donations: null
  }),
  actions: {
    async sendDonation(donationData) {
      try {
        const response = await api.post('/api/donations', donationData)
        this.campaigns = response.data
        return response
      } catch (err) {
        console.log("Failed to make a donation ", err)
      }
    },
    async test() {
      try {
        const response = await api.post('/api/test-cors')
        this.campaigns = response.data
        return response
      } catch (err) {
        console.log("Failed to make a donation ", err)
      }
    }
  },
});
