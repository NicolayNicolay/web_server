<template>
  <header class="bd-header pt-3 border-bottom bg-light">
    <div class="bd-header-start position-relative">
      <menu-icon class="menu-icon icon d-md-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"/>
      <div class="status-server position-absolute end-0 top-0 pe-4">
        <div class="btn btn-status text-uppercase" :class="statusParams.serverData.status.header_class" @click="openModal" v-if="Object.keys(statusParams.serverData).length !== 0">
          {{ statusParams.serverStatus }}
        </div>
      </div>
      <h3 class="text-center mb-4 mb-md-0 main-title">{{ statusParams.serverTitle }}</h3>
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
import {useModal} from "@/composables/useModal";
import {useStatus} from "@/composables/useStatus";
import MenuIcon from "@/components/Icons/MenuIcon.vue";
import MobileMenu from "@/components/Menu/MobileMenu.vue";
import ServerStatusModal from '@/components/Modals/ServerStatusModal.vue'

const route = useRoute();
const modal = useModal()
const {statusParams, checkStatus} = useStatus()
const windowWidth = ref(window.innerWidth)
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
const handleResize = () => {
  getStatusesData();
}

onMounted(() => {
  getActiveMenuItem();
  checkStatus().then(() => {
    getStatusesData();
    window.addEventListener('resize', handleResize)
  });
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})


function getStatusesData() {
  windowWidth.value = window.innerWidth;
  if (window.innerWidth < 768) {
    statusParams.serverStatus = statusParams.serverData.status.value;
    statusParams.serverTitle = 'Tegraserver monitoring';
  } else {
    statusParams.serverStatus = 'SERVER IS ' + statusParams.serverData.status.value;
    statusParams.serverTitle = 'Tegraserver monitoring and control';
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
  if (statusParams.serverData.status.state == 2 || statusParams.serverData.status.state == 3) {
    modal.open({
      component: ServerStatusModal,
    })
  }
}
</script>
