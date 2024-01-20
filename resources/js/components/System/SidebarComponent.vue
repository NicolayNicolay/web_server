<template>
  <div class="bd-sidebar bg-light border-end py-5 px-4" id="bd_sidebar" v-show="sidebar.length > 0">
    <div class="bd-menu d-flex justify-content-center d-none d-lg-block">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item" v-for="(item, index) in sidebar" :key="index">
          <a :href="item.url" class="nav-link" :class="[item.active ? 'active': '', classBtn]" v-html="item.name"></a>
        </li>
      </ul>
    </div>
    <div class="bd-menu">
      <div ref="horizontal-scroll-container" class="horizontal-scroll-container d-lg-none mx-n20">
        <div ref="scrollWrapper" class="scroll-wrapper">
          <div class="scroll-content d-flex px-20">
            <ul class="nav nav-pills flex-nowrap">
              <li class="nav-item" v-for="(item, index) in sidebar" :key="index">
                <a :href="item.url" class="nav-link" :class="[item.active ? 'active': '', classBtn]" v-html="item.name"></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {ref, onMounted, onUnmounted} from "vue";
import {useRoute} from 'vue-router';
import BScroll from '@better-scroll/core';
import {sidebarValues} from "@/sidebar";

const route = useRoute();
const windowWidth = ref(window.innerWidth)
const classBtn = ref('btn-lg');
const scrollWrapper = ref();
const sidebar = ref(sidebarValues[route.fullPath.split('/')[1] as keyof object]);
const handleResize = () => {
  windowWidth.value = window.innerWidth;
  if (window.innerWidth < 768) {
    classBtn.value = '';
  } else {
    classBtn.value = 'btn-lg';
  }
}

onMounted(() => {
  if (window.innerWidth < 768) {
    classBtn.value = '';
  }
  window.addEventListener('resize', handleResize)
  initScroll();
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})

getActiveMenuItem();

function getActiveMenuItem() {
  sidebar.value.forEach((item: any) => {
    if (route.fullPath == item.url) {
      item.active = true;
    }
  })
}

function initScroll() {
  new BScroll(scrollWrapper.value, {
    scrollX: true,
    probeType: 3,
    click: true
  });
}
</script>
