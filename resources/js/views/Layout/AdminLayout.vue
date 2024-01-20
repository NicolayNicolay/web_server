<template>
  <header-component/>
  <div class="d-flex flex-column flex-grow-1 flex-lg-row main-wrapper">
    <sidebar-component/>
    <main class="bd-content px-4 py-5 w-100" id="bd-content">
      <slot></slot>
    </main>
  </div>
  <footer-component/>
</template>

<script lang="ts" setup>
import HeaderComponent from "@/components/System/HeaderComponent.vue";
import FooterComponent from "@/components/System/FooterComponent.vue";
import SidebarComponent from "@/components/System/SidebarComponent.vue";
import {useRoute} from 'vue-router';

const route = useRoute();

</script>
