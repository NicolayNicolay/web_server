<template>
  <admin-layout>
    <div v-if="!loading">
      <div class="alert alert-info" v-if="empty">Данные отсутствуют</div>
      <v-chart class="chart mt-4 border p-2" :option="option" v-else/>
    </div>
    <loading-component v-else></loading-component>
  </admin-layout>
</template>

<script setup lang="ts">
import AdminLayout from "@/views/Layout/AdminLayout.vue";
import {use} from "echarts/core";
import {ref, provide, onMounted} from "vue";
import {CanvasRenderer} from "echarts/renderers";
import {
  LineChart,
} from "echarts/charts";
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  VisualMapComponent,
  GridComponent,
  ToolboxComponent,
  DataZoomComponent,
  CalendarComponent,
  TimelineComponent,
} from "echarts/components";
import VChart, {THEME_KEY} from "vue-echarts";
import axios from "axios";
import LoadingComponent from "@/components/System/LoadingComponent.vue";

use([
  CanvasRenderer,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  LineChart,
  VisualMapComponent,
  GridComponent,
  ToolboxComponent,
  DataZoomComponent,
  CalendarComponent,
  TimelineComponent,
]);

provide(THEME_KEY, "default");

const option = ref({
  grid: {
    left: 80,
    right: 80,
    bottom: 20,
    top: 40,
    containLabel: true
  },
  tooltip: {
    trigger: "axis",
    className: "echarts-tooltip-bank",
    axisPointer: {
      type: "cross",
      animation: "true",
      label: {
        "backgroundColor": "#6a7985"
      }
    }
  },
  xAxis: [],
  yAxis: [
    {
      type: "value"
    }
  ],
  legend: {
    type: "scroll",
    data: [],
    show: true,
    orient: "vertical",
    left: "80%",
    right: 20,
    top: 20,
    bottom: 20,
    // icon: "circle",
    padding: [
      40,
      10,
      40,
      10
    ],
    textStyle: {
      "width": 150,
      "overflow": "truncate",
      "ellipsis": "truncate"
    },
    labels: {
      "fontWeight": "bold"
    }
  },
  series: []
});
const loading = ref(true)
const empty = ref(false)
onMounted(() => {
  getData();
})

async function getData() {
  loading.value = true;
  await axios.get('/api/cpus/getData')
    .then((response) => {
      if (response.data.series.length > 0) {
        option.value.series = response.data.series
        option.value.xAxis = response.data.xAxis
        option.value.legend.data = response.data.legend
      } else {
        empty.value = true
      }
    })
    .catch(() => {
    })
    .finally(() => {
      loading.value = false;
    })
}
</script>
<style scoped>
.chart {
  height: 400px;
}
</style>
