<template>
  <div class="modal-overlay">
    <div class="modal">
      <h2>Campaign: {{ campaign.name }}</h2>
      <BForm @submit.prevent="submitDonation">
        <label class="mr-sm-2 header-text mt-2" for="input-2">Pledged amount</label>
        <BFormInput
          id="input-1"
          v-model="pledgedAmount"
          type="number"
          step="0.01"
          placeholder="Pleadged amount: 0.00$"
          class="campaign-input px-2"
          min="0"
        />
        <div class="col-12 text-right">
          <BButton type="submit" pill variant="primary" :disabled="isProcessing">Confirm</BButton>
          <BButton @click="closeModal" type="button" pill variant="danger" :disabled="isProcessing">Cancel</BButton>
        </div>
      </BForm>
    </div>
  </div>
</template>
  
<script setup>
import { defineProps, defineEmits, ref } from 'vue';

const props = defineProps({
  campaign: Object,
});

const isProcessing = ref(false)
const pledgedAmount = ref(0)
const emit = defineEmits(['sendDonation', 'closeModal', 'get']);

async function submitDonation() {
  isProcessing.value = true

  await emit('sendDonation', {
    amount: pledgedAmount.value,
    campaign_id: props.campaign.id
  })

  await emit('refreshCampaigns')
  isProcessing.value = false
  emit('closeModal')
};

function closeModal(e) {
  e.preventDefault() // prevent refresh
  emit('closeModal')
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
  