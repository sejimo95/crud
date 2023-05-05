
const routes = [
  // admin
  {
    path: '/',
    component: () => import('layouts/AdminLayout.vue'),
    children: [
      { path: '/admin/dashboard', component: () => import('pages/Admin/Dashboard/IndexPage.vue') }
    ]
  },
  {
    path: '/admin/login',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Auth/Admin/LoginPage.vue') }
    ]
  },

  // client
  {
    path: '/',
    component: () => import('layouts/ClientLayout.vue'),
    children: [
      { path: '/dashboard', component: () => import('pages/Client/Dashboard/IndexPage.vue') },
      { path: '/statements', component: () => import('pages/Client/Statement/IndexPage.vue') }
    ]
  },
  {
    path: '/login',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Auth/Client/LoginPage.vue') }
    ]
  },
  {
    path: '/register',
    component: () => import('layouts/AuthLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Auth/RegisterPage.vue') }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
