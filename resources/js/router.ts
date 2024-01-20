import {createRouter, createWebHistory, RouteRecordRaw} from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    name: 'HomePage',
    path: '/',
    redirect: '/status',
    meta: {
      requiresAuth: true,
    },
  },
  {
    name: 'StatusPage',
    path: '/status',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Status/StatusPage.vue')
  },
  {
    name: 'ActiveDevices',
    path: '/status/activeDevices',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Status/ActiveDevicesPage.vue')
  },
  {
    name: 'ActiveFaults',
    path: '/status/activeFaults',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Status/ActiveFaultsPage.vue')
  },
  {
    name: 'ControlPage',
    path: '/control',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Control/ControlPage.vue')
  },
  {
    name: 'ControlDevicesPage',
    path: '/control/controlDevices',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Control/ControlDevicesPage.vue')
  },
  {
    name: 'ControlDevicesTemperaturePage',
    path: '/control/controlDevicesTemperature',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Control/ControlDevicesTemperaturePage.vue')
  },
  {
    name: 'CpusPage',
    path: '/cpus',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Cpus/CpusPage.vue')
  },
  {
    name: 'CpusTemperaturePage',
    path: '/cpus/temperature',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Cpus/TemperaturePage.vue')
  },
  {
    name: 'CoolingPage',
    path: '/cooling',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Cooling/CoolingPage.vue')
  },
  {
    name: 'CoolingFansPage',
    path: '/cooling/fans',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Cooling/FansPage.vue')
  },
  {
    name: 'SwitchPage',
    path: '/switch',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Switch/SwitchPage.vue')
  },
  {
    name: 'SwitchDebugPage',
    path: '/switch/debug',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Switch/DebugPage.vue')
  },
  {
    name: 'ControllerPage',
    path: '/controller',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Controller/ControllerPage.vue')
  },
  {
    name: 'ControllerDebugPage',
    path: '/controller/debug',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Controller/DebugPage.vue')
  },
  {
    name: 'AdminPage',
    path: '/admin',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Admin/AdminPage.vue')
  },
  {
    name: 'AdminLogsPage',
    path: '/admin/logs',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Admin/LogsPage.vue')
  },
  {
    name: 'AdminSupportPage',
    path: '/admin/support',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Admin/SupportPage.vue')
  },
  {
    name: 'UpgradePage',
    path: '/admin/upgrade',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Admin/UpgradePage.vue')
  },
  {
    name: 'UsersPage',
    path: '/admin/users',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Admin/UsersPage.vue')
  },
  {
    name: 'UiPage',
    path: '/ui',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/System/UiPage.vue')
  },
  {
    name: 'Chart',
    path: '/chart',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/System/ChartPage.vue')
  },
  {
    name: 'Login',
    path: '/login',
    meta: {
      onlyGuests: true,
    },
    component: () => import('@/views/Auth/LoginPage.vue')
  },
  {
    path: '/404',
    name: 'NotFound',
    component: () => import('@/views/System/404.vue')
  },
  {
    path: '/:catchAll(.*)',
    redirect: '/404',
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
