<template>
  <div id="main-div">
    <router-view v-if="!appSetup.appLoading"></router-view>
    <div class="app-msg" v-else>APPLICATION IS LOADING...</div>
  </div>
</template>

<script setup>
import { onMounted, reactive } from 'vue';
import { useSettingsStore } from './stores/settings/settings';
    
const settingsStore = useSettingsStore();

const appSetup = reactive({
  appLoading: true
})

onMounted(async () => {
  //await settingsStore.getApplicationSettings()
  appSetup.appLoading = false
})

</script>

<style>

body {
  font-family: Arial, sans-serif;
  background: #f4f4f4;
  text-align: center;
  padding: 20px;
}

.app-msg {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-weight: 600;
}

</style>
