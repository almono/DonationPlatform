<template>
  <div>
    <BCard
      :title="'Dashboard'"
      tag="article"
      style="max-width: 90vw"
      class="mx-auto my-auto text-left d-flex align-center justify-center register-card"
    >
    <BButton pill variant="danger" @click="logout">Logout</BButton>
      <BCardText class="align-right card-body-content mt-2">
        <hr class="divide-line" />
        <div class="col-12 px-0">Available campaigns</div>
        <hr class="divide-line" />
        <template v-if="data.loadingCampaigns">
          <span>Loading available campaigns...</span>
        </template>
        <template v-else>
          <div class="row">
            <div v-if="campaignsStore?.campaigns && Object.keys(campaignsStore?.campaigns).length > 0" class="col-7">
              <div v-for="campaign in campaignsStore.campaigns" class="col-12 d-block px-1 campaign-main my-2">
                <div class="col-12 px-1 mt-1 campaign-title">
                  <div class="title-span">
                    <div>{{ campaign.name }} <span class="text-red" v-if="!campaign.is_active">( FINISHED )</span> </div>
                  </div>
                  <template v-if="authStore?.user?.role === 'Admin'">
                    <BFormCheckbox switch size="lg" v-model="campaign.is_active" :value="1" :unchecked-value="0" @change="(event) => updateCampaignState(event, campaign)"></BFormCheckbox>
                  </template>
                </div>
                <template v-if="authStore?.user?.role === 'Admin'">
                  <BButton class="donate-btn" variant="outline-primary" @click="openEditModal(campaign)">Edit</BButton>
                  <BButton class="donate-btn mx-2" variant="danger" @click="deleteCampaign(campaign)">Delete</BButton>
                </template>
                <hr class="campaign-line" />
                <div class="col-12 px-1 campaign-desc">
                  {{ campaign.description }}
                </div>
                <hr class="campaign-line" />
                <div class="row mx-0 col-12 px-0 mb-2 mt-2 campaign-desc">
                  <div class="col-6 px-0">
                    <BButton class="donate-btn" pill variant="success" @click="openDonationModal(campaign)" :disabled="!campaign.is_active">Donate</BButton>
                  </div>
                  <div class="col-6 pledge-text">
                    <span>Pledged: {{ campaign.donations_sum_amount }}$</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-7" v-else>
              <div class="col-12 text-left">
                <span class="message">No Campaigns are available</span>
              </div>
            </div>
            <div v-if="authStore?.user?.role === 'Admin'" class="col-5">
              <div class="col-12 d-block px-1 campaign-main my-2">
                <div class="col-12 px-0 campaign-title">Admin Actions</div>
                <hr class="campaign-line" />
                <BButton class="donate-btn" pill variant="success" @click="openNewCampaignModal">Create New Campaign</BButton>
                <hr class="campaign-line" />
                <template v-if="authStore?.user?.role === 'Admin'">
                  <BFormCheckbox switch size="lg" v-model="registrationEnabled" :value="1" :unchecked-value="0" @change="updateApplicationSetting()">Registration Enabled</BFormCheckbox>
                </template>
              </div>
            </div>
          </div>
        </template>
      </BCardText>
    </BCard>
    <DonationModal
      v-if="isDonationModalOpen"
      :campaign="selectedCampaign"
      @sendDonation="sendDonation"
      @closeModal="closeModal"
      @refreshCampaigns="refreshCampaigns"
    />
    <NewCampaignModal
      v-if="isNewCampaignModalOpen"
      @createNewCampaign="createNewCampaign"
      @closeNewCampaignModal="closeNewCampaignModal"
      @refreshCampaigns="refreshCampaigns"
    />
    <EditCampaignModal
      v-if="isEditCampaignModalOpen"
      :campaign="selectedCampaign"
      @editCampaign="updateCampaignDetails"
      @closeEditCampaignModal="closeEditCampaignModal"
      @refreshCampaigns="refreshCampaigns"
    />
  </div>
</template>

<script setup>
import { onMounted, ref, reactive, computed } from 'vue';
import { useSettingsStore } from '../stores/settings/settings';
import { useAuthStore } from '../stores/auth/auth';
import { useCampaignsStore } from '../stores/campaigns/campaigns';
import { useDonationsStore } from '../stores/donations/donations';
import { useGroupsStore } from '../stores/groups/groups';
import { BFormCheckbox, BFormInput, BInputGroup } from 'bootstrap-vue-next';
import DonationModal from '../components/DonationModal.vue';
import NewCampaignModal from '../components/NewCampaignModal.vue';
import EditCampaignModal from '../components/EditCampaignModal.vue';

const authStore = useAuthStore()
const campaignsStore = useCampaignsStore()
const donationsStore = useDonationsStore()
const groupStore = useGroupsStore()
const settingsStore = useSettingsStore()

const isDonationModalOpen = ref(false)
const isNewCampaignModalOpen = ref(false)
const isEditCampaignModalOpen = ref(false)
const selectedCampaign = ref(null)
const updateCampaign = ref(null)

const data = reactive({
  loadingCampaigns: false
})

onMounted(async () => {
  data.loadingCampaigns = true
  await campaignsStore.getCampaignsList()
  data.loadingCampaigns = false
  await groupStore.getGroups()
})

const registrationEnabled = computed({
  get: () => settingsStore.settings.registration_enabled === 1, // Convert 1 to true and 0 to false
  set: (value) => settingsStore.toggleRegistration(value ? 1 : 0), // Convert true to 1 and false to 0
})

function openDonationModal(campaign) {
  selectedCampaign.value = { ...campaign } // we are copying the values to not update the original campaign just in case
  isDonationModalOpen.value = true
}

function openNewCampaignModal() {
  isNewCampaignModalOpen.value = true
}

function closeModal() {
  isDonationModalOpen.value = false
}

function closeNewCampaignModal() {
  isNewCampaignModalOpen.value = false
}

function closeEditCampaignModal() {
  isEditCampaignModalOpen.value = false
}

async function refreshCampaigns() {
  await campaignsStore.getCampaignsList()
}

async function sendDonation(donation) {
  await donationsStore.sendDonation(donation)
}

async function createNewCampaign(data) {
  await campaignsStore.createNewCampaign(data)
}

async function updateCampaignState(event, campaign) {
  updateCampaign.value = { ...campaign }
  await campaignsStore.updateCampaign(campaign)
}

async function updateCampaignDetails(campaign) {
  updateCampaign.value = { ...campaign }
  await campaignsStore.updateCampaign(campaign)
  await campaignsStore.getCampaignsList()
}

function openEditModal(campaign) {
  selectedCampaign.value = { ...campaign }
  isEditCampaignModalOpen.value = true
}

async function deleteCampaign(campaign) {
  await campaignsStore.deleteCampaign(campaign)
  await campaignsStore.getCampaignsList()
}

async function logout() {
  await authStore.logout()
}

async function updateApplicationSetting() {
  await settingsStore.updateApplicationSettings()
}

</script>
  
<script>
export default {
  name: "Dashboard",
};
</script>

<style scoped>
h2 {
  color: #42b983;
}

.divide-line {
  margin-top: 5px;
  margin-bottom: 5px;
}

.message {
  font-weight: 600;
  color: black;
}

.campaign-main {
  border: 1px solid rgba(128, 128, 128, 0.788);
  border-radius: 5px;
}

.campaign-title {
  font-weight: 600;
  color: black;
  display: flex;
  justify-content: space-between;
}

.title-span {
  display: flex;
  align-items: center;
}

.campaign-line {
  margin-top: 5px;
  margin-bottom: 5px;
}

.campaign-input {
  border-radius: 0px;
  padding-left: 5px;
  color: rgb(90, 90, 90) !important;
  height: 3rem;
  border: 0px 0px 1px 1px gray solid;
}

.campaign-desc {
  display: flex;
}

.header-text {
  font-weight: 600;
}

.text-red {
  color: red;
  font-weight: 600;
}

.pledge-text {
  font-weight: 600;
  align-items: end;
  justify-content: end;
  display: flex;
}

</style>
