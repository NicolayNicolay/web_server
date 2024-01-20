<template>
  <header class="bd-header pt-3 border-bottom bg-light">
    <div class="bd-header-start position-relative">
      <menu-icon class="menu-icon icon d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"/>
      <div class="status-server position-absolute end-0 top-0 pe-4">
        <div class="btn btn-status text-uppercase" :class="status.status.header_class" @click="openModal" v-if="status">
          {{ serverStatus }}
        </div>
      </div>
      <h3 class="text-center mb-4 mb-md-0 main-title">{{ serverTitle }}</h3>
      <div class="d-none d-md-block">
        <ul class="nav nav-pills justify-content-center mt-4 mb-4">
          <li class="nav-item" v-for="(item, index) in menuItems" :key="index">
            <a :href="item.url" class="nav-link" :class="item.active ? 'active': ''">{{ item.name }}</a>
          </li>
        </ul>
      </div>
    </div>
    <mobile-menu :items="menuItems"/>
  </header>
</template>
<script setup lang="ts">
import {onMounted, onUnmounted, ref} from "vue";
import {useRoute} from 'vue-router';
import {statusStore} from "@/stores/statusStore";
import {useModal} from "@/composables/useModal";
import MenuIcon from "@/components/Icons/MenuIcon.vue";
import MobileMenu from "@/components/Menu/MobileMenu.vue";
import ServerStatusModal from '@/components/Modals/ServerStatusModal.vue'

const status = statusStore();
const route = useRoute();
const windowWidth = ref(window.innerWidth)
const serverStatus = ref('Server is on')
const serverTitle = ref('Tegraserver monitoring and control')
const modal = useModal()
const handleResize = () => {
  getStatusesData();
}

onMounted(() => {
  status.checkStatus().then(() => {
    getStatusesData();
    window.addEventListener('resize', handleResize)
  });
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})
const menuItems = ref([
  {
    'name': 'Status',
    'url': '/status',
  },
  {
    'name': 'Control',
    'url': '/control',
  },
  {
    'name': 'CPUs',
    'url': '/cpus',
  },
  {
    'name': 'Cooling',
    'url': '/cooling',
  },
  {
    'name': 'Switch',
    'url': '/switch',
  },
  {
    'name': 'Controller',
    'url': '/controller',
  },
  {
    'name': 'Admin area',
    'url': '/admin',
  },
])

getActiveMenuItem();

function getStatusesData() {
  windowWidth.value = window.innerWidth;
  if (window.innerWidth < 768) {
    serverStatus.value = status.status.value.toUpperCase();
    serverTitle.value = 'Tegraserver monitoring';
  } else {
    serverStatus.value = 'Server is ' + status.status.value;
    serverTitle.value = 'Tegraserver monitoring and control';
  }
}

function getActiveMenuItem() {
  menuItems.value.forEach((item) => {
    if (route.fullPath.indexOf(item.url) >= 0 && (route.fullPath.length > item.url.length ? route.fullPath[item.url.length] == '/' : true)) {
      item.active = true;
    }
  })
}

function openModal() {
  if (status.status.state == 2 || status.status.state == 3) {
    modal.open({
      component: ServerStatusModal,
    })
  }
}
</script>
