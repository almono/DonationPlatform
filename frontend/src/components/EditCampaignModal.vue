<template>
  <div class="modal-overlay">
    <div class="modal">
      <h2>New Campaign</h2>
      <BForm @submit.prevent="editCampaign">
        <label class="mr-sm-2 header-text mt-2" for="input-2">Campaign Name</label>
        <BFormInput
          id="input-1"
          v-model="campaign.name"
          type="text"
          placeholder="Campaign Name"
          class="campaign-input px-2"
        />

        <label class="mr-sm-2 header-text mt-2" for="input-2">Campaign Description</label>
        <BFormInput
          id="input-2"
          v-model="campaign.description"
          type="text"
          placeholder="Campaign Description"
          class="campaign-input px-2"
        />

        <label class="mr-sm-2 header-text mt-2" for="input-2">Campaign Group</label>
        <BFormSelect
          v-model="campaign.group_id"
          :options="groupStore.groups"
          class="mb-3"
          value-field="id"
          text-field="name"
        ></BFormSelect>

        <div class="col-12 text-right">
          <BButton type="submit" pill variant="primary" :disabled="isProcessing">Confirm</BButton>
          <BButton @click="closeModal" type="button" pill variant="danger" :disabled="isProcessing">Cancel</BButton>
        </div>
      </BForm>
    </div>
  </div>
</template>
  
<script setup>
import { defineProps, defineEmits, ref, reactive } from 'vue';
import { useGroupsStore } from '../stores/groups/groups';
import { BFormInput, BFormSelect } from 'bootstrap-vue-next';

const groupStore = useGroupsStore()

const props = defineProps({
  campaign: Object,
});

const isProcessing = ref(false)
const emit = defineEmits(['editCampaign', 'closeEditCampaignModal', 'get']);

async function editCampaign() {
  isProcessing.value = true
  await emit('editCampaign', props.campaign)
  await emit('refreshCampaigns')
  isProcessing.value = false
  emit('closeEditCampaignModal')
};

function closeModal(e) {
  e.preventDefault() // prevent refresh
  emit('closeEditCampaignModal')
};

</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal {
  display: block;
  position: relative;
  background: white;
  padding: 20px;
  border-radius: 5px;
  width: 30vw;
  min-height: 150px;
  z-index: 10000;
  height: auto;
}

button {
  margin-top: 10px;
}
</style>
  