import { defineStore } from 'pinia';
import api from '../../api.js';

export const useGroupsStore = defineStore('groups', {
  state: () => ({
    groups: null
  }),
  actions: {
    async getGroups() {
      try {
        const response = await api.get('/api/groups')
        this.groups = response.data
        return response
      } catch (err) {
        console.log("Failed to load groups ", err)
      }
    }
  },
});
