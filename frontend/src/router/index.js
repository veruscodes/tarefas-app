// src/router/index.js
import Vue from 'vue';
import Router from 'vue-router';

import LoginPage from '../components/Login.vue';
import RegisterCompanyPage from '../components/RegisterCompanyPage.vue';
import TasksPage from '../components/Tasks.vue';
import DashboardPage from '../components/DashboardPage.vue';

Vue.use(Router);

const router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: LoginPage,
      meta: { requiresAuth: false }, // rota pública
    },
    {
      path: '/register',
      name: 'Register',
      component: RegisterCompanyPage,
      meta: { requiresAuth: false }, // rota pública
    },
    {
      path: '/dashboard', // ✅ ROTA NOVA
      name: 'Dashboard',
      component: DashboardPage,
      meta: { requiresAuth: true }, // rota protegida
    },
    {
      path: '/tasks',
      name: 'Tasks',
      component: TasksPage,
      meta: { requiresAuth: true }, // rota protegida
    },
    {
      path: '*',
      redirect: '/login', // rota padrão
    },
  ],
});

// Middleware global
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token');

  if (to.matched.some(record => record.meta.requiresAuth)) {
    // se precisa estar logado
    if (!isAuthenticated) {
      next('/login');
    } else {
      next();
    }
  } else {
    // se já está logado e tenta acessar login/register → manda pra dashboard
    if (isAuthenticated && (to.path === '/login' || to.path === '/register')) {
      next('/dashboard'); // ✅ ALTERADO: tasks → dashboard
    } else {
      next();
    }
  }
});

export default router;