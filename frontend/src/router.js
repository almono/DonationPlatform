import api from './api.js';
import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from './stores/auth/auth';
import Login from './views/auth/Login.vue';
import Register from './views/auth/Register.vue';
import Dashboard from './views/Dashboard.vue';

const routes = [
  { path: '/', component: Login },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { 
    path: '/dashboard', 
    component: Dashboard,
    meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to) => {
  const authStore = useAuthStore();

  await new Promise(resolve => setTimeout(resolve, 50));
  if (!authStore.user) {
    await api.get('/sanctum/csrf-cookie');
    await authStore.fetchUser();
  }
  
  if (to.meta.requiresAuth && !authStore.user) {
    return '/login';
  }
});

export default router;
