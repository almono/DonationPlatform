import { defineStore } from 'pinia';
import api from '../../api.js';

export const useCampaignsStore = defineStore('campaigns', {
  state: () => ({
    campaigns: null
  }),
  actions: {
    async getCampaignsList() {
      try {
        const response = await api.get('/api/campaigns')
        this.campaigns = response.data
        return response
      } catch (err) {
        console.log("Failed to load campaigns ", err)
      }
    },
    async createNewCampaign(data) {
      try {
        const response = await api.post('/api/campaigns', data)
        return response
      } catch (err) {
        console.log("Failed to create new campaigns ", err)
      }
    },
    async updateCampaign(data) {
      try {
        const response = await api.put(`/api/campaigns/${data.id}`, data)
        return response
      } catch (err) {
        console.log("Failed update campaign ", err)
      }
    },
    async deleteCampaign(data) {
      try {
        const response = await api.delete(`/api/campaigns/${data.id}`, data)
        return response
      } catch (err) {
        console.log("Failed to delete campaign ", err)
      }
    }
  },
});
