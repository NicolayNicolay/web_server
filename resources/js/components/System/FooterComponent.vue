<template>
  <footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container-fluid d-flex align-items-center">
      <span class="text-muted">&copy; «SMD» 2023</span>
      <a href="/api/logout" class="btn btn-secondary btn-sm ms-auto">Logout</a>
    </div>
    <modal-component />
  </footer>
</template>
<script setup lang="ts">
import ModalComponent from "@/components/Modals/ModalComponent.vue";
</script>
