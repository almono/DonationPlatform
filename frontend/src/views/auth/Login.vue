<template>
  <div>
    <BCard
      title="Sign In"
      img-src="https://picsum.photos/id/25/600/300"
      img-alt="Login-Image"
      img-top
      tag="article"
      style="max-width: 25rem"
      class="mx-auto my-auto text-left d-flex align-center justify-center login-card"
    >
      <BForm @submit.prevent="loginUser()">
        <BCardText class="align-right mt-4">
          <BFormInput
            id="input-1"
            v-model="loginForm.email"
            type="email"
            placeholder="Enter email"
            class="login-input px-2"
            required
            autofocus
          />
          <BInputGroup class="mt-3">
            <template #append>
              <BInputGroupText class="pass-append">
                <i id="forgot-pass-eye" :class="data.showPassword === false ? 'bi bi-eye-slash' : 'bi bi-eye-fill'" @click="togglePassword()"></i>
              </BInputGroupText>
            </template>
            <BFormInput
              id="input-2"
              v-model="loginForm.password"
              :type="data.showPassword === false ? 'password' : 'text'"
              placeholder="Enter password"
              class="login-input px-2"
              required
            />
          </BInputGroup>
          <span class="text-red-700 font-bold error-msg my-2" v-if="data?.validationErrors">
            <li class="d-block px-0" v-for="(err, val) in data.validationErrors">{{ err }}</li>
          </span>
        </BCardText>

        <div class="row mx-0 d-flex" v-if="data.loginError">
          <span class="col-12 text-center invalid-login-text">Invalid login credentials provided</span>
        </div>
        <div class="col-12 px-0 text-center align-items-center justify-content-center mt-3">
          <BButton class="col-8" pill variant="primary" type="submit" v-if="!data.requestProcessing">Sign In</BButton>
          <BButton class="col-8" pill variant="primary" v-else :disabled="true">Processing...</BButton>
        </div>
        <template v-if="settingsStore?.settings?.registration_enabled">
          <span class="col-12 px-0 justify-content-center d-flex my-2 or-span">or</span>
          <div class="col-12 px-0 text-center">
            <BButton class="col-6" type="button" pill variant="outline-secondary" @click="goToRegistration()">Register</BButton>
          </div>
        </template>
      </BForm>
    </BCard>
  </div>
</template>

<script setup>
import { useSettingsStore } from '../../stores/settings/settings';
import { useAuthStore } from '../../stores/auth/auth'

const settingsStore = useSettingsStore();
const authStore = useAuthStore();

const data = reactive({
  showPassword: false,
  requestProcessing: false,
  validationErrors: null,
  loginError: null
})

const loginForm = reactive({
  email: null,
  password: null
})

function loginUser() {
  data.loginError = null
  data.requestProcessing = true

  authStore.login({
    email: loginForm.email,
    password: loginForm.password
  }).then(response => {
    data.requestProcessing = false
    
    data.validationErrors = response?.status    === 422 ? response?.data?.errors : null
    data.loginError = response?.status          === 401 ? response?.data?.message : null
    data.registrationResult = response?.status  === 201 ? response?.data?.message : null
  })
}

function togglePassword() {
  data.showPassword = !data.showPassword
}

</script>

<script>
import { BButton, BForm, BFormGroup, BFormInput, BInputGroup, BInputGroupText } from 'bootstrap-vue-next';
import { reactive } from 'vue';

export default {
  name: "Login",
  methods: {
    goToRegistration() {
      this.$router.push({path: '/register'})
    }
  }
};
</script>
  
<style scoped>

h2 {
  color: #42b983;
}

.login-input {
  border-radius: 0px;
  padding-left: 5px;
  color: rgb(90, 90, 90) !important;
  height: 3rem;
  border: 0px 0px 1px 1px gray solid;
}

.error-msg {
  color: red !important;
}

.forgot-password {
  color: rgb(0, 174, 255) !important;
  cursor: pointer !important;
  font-size: 14px;
  font-weight: 600 !important;
}

.forgot-password:hover {
  text-decoration: underline;
}

.new-account-text {
  cursor: pointer !important;
}

.new-account-text:hover {
  text-decoration: underline;
}

.or-span {
  padding-left: 10px;
}

.or-span::before, .or-span::after {
  content: "";
  flex: 1 1;
  margin: auto;
}

.or-span::after, .or-span::before {
  border-bottom: 1px #8080806b solid;
  margin-right: 10px;
  margin-left: 10px;
}

.invalid-login-text {
  color: red;
  font-size: 14px;
  font-weight: 600;
}

.card-body > h4 {
  font-size: 30px !important;
}

.login-card {
  box-shadow: 3px 3px 3px rgba(201, 201, 201, 0.438);
}

#forgot-pass-eye {
  color: rgb(0, 121, 177) !important;
  font-size: 20px;
}

.pass-append {
  height: 3rem;
}
</style>
  