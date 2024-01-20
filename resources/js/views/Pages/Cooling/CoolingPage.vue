<template>
  <admin-layout>
    <div v-if="!loading">
      <div class="alert alert-info" v-if="empty">Данные отсутствуют</div>
      <div class="row" v-else>
        <div class="col-12">
          <v-chart ref="graph" class="chart mt-4 border" :option="option" :key="update"/>
        </div>
        <div class="col-12">
          <div class="d-flex pt-3">
            <button class="btn border btn-lg" :class="active.cpus? 'btn-primary' : ''" @click="toggleActive('cpu')">
              CPUs
            </button>
            <button class="btn border btn-lg ms-3" :class="active.switch? 'btn-primary' : ''" @click="toggleActive('switch')">
              Switch
            </button>
            <button class="btn border btn-lg ms-3" :class="active.controller? 'btn-primary' : ''" @click="toggleActive('controller')">
              Controller
            </button>
            <button class="btn border btn-lg ms-3" :class="active.psu? 'btn-primary' : ''" @click="toggleActive('psu')">
              PSU
            </button>
          </div>
        </div>
      </div>
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
  TimelineComponent, MarkAreaComponent,
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
  MarkAreaComponent
]);

provide(THEME_KEY, "default");

const graph = ref()
const update = ref(0)
const option = ref({
  grid: {
    left: "3%",
    right: "22%",
    bottom: 40,
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
  dataZoom: [
    {
      type: 'inside',
      realtime: true,
      start: 0,
    }
  ],
  series: [
    {
      type: 'line',
      markArea: {
        itemStyle: {
          color: 'rgba(0, 255, 0, 0.2)'
        },
        data: [
          [
            {
              coord: [, 50]
            },
            {
              coord: [, 0]
            }
          ]
        ]
      }
    },
    {
      type: 'line',
      markArea: {
        itemStyle: {
          color: 'rgba(255, 255, 0, 0.2)'
        },
        data: [
          [
            {
              coord: [, 79]
            },
            {
              coord: [, 50]
            }
          ]
        ]
      }
    },
    {
      type: 'line',
      markArea: {
        itemStyle: {
          color: 'rgba(255, 0, 0, 0.2)'
        },
        data: [
          [
            {
              coord: [, 100]
            },
            {
              coord: [,]
            }
          ]
        ]
      }
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
});
const data = ref([])
const loading = ref(true)
const empty = ref(false)

interface ObjectNumber {
  [key: string]: number;
}

interface ObjectBool {
  cpu: boolean,
  switch: boolean,
  controller: boolean,
  psu: boolean,
}

const active = ref<ObjectBool>({
  cpu: false,
  switch: false,
  controller: false,
  psu: false,
})
const categories = ref<ObjectNumber>({});

onMounted(() => {
  getData();
})

async function getData() {
  loading.value = true;
  await axios.get('/api/cooling/getData')
    .then((response) => {
      data.value = response.data;
      if (response.data.series.length > 0) {
        categories.value = response.data.categories
        option.value.series.push(...response.data.series)
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

function toggleActive(code: 'cpu' | 'switch' | 'controller' | 'psu') {
  active.value[code] = !active.value[code]
  let needGroup: number = categories.value[code]
  option.value.series.forEach((element) => {
    if (element.dataGroupId) {
      if (needGroup == element.dataGroupId) {
        graph.value.dispatchAction({type: 'legendToggleSelect', name: element.name})
      }
    }
  });
  console.log(option.value.series)
}
</script>
<style scoped>
.chart {
  height: 400px;
}

.btn {
  --bs-btn-hover-bg: #0d6efd;
  --bs-btn-hover-color: white;
}
</style>
