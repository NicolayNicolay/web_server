<template>
  <admin-layout>
    <div v-if="!loading">
      <div class="row">
        <div class="col-12 mt-4">
          <div class="row">
            <div class="col-12 col-sm-4 col-md-3">
              <div class="btn-wrapper d-flex flex-column">
                <button class="btn btn-danger btn-lg p-2 fw-semibold" @click.prevent="turnOffModal">
                  Turn OFF
                </button>
                <div class="text mt-3">
                  Controller software power off by OS command 'poweroff'
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4 col-md-3 mt-3 mt-sm-0">
              <div class="btn-wrapper d-flex flex-column">
                <button class="btn btn-primary btn-lg p-2 fw-semibold" @click.prevent="softRebootModal">
                  Soft Reboot
                </button>
                <div class="text mt-3">
                  Software Reboot by OS command
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4 col-md-3 mt-3 mt-sm-0">
              <div class="btn-wrapper d-flex flex-column">
                <button class="btn btn-primary btn-lg p-2 fw-semibold" @click.prevent="hardRebootModal">
                  Hard Reboot
                </button>
                <div class="text mt-3">
                  Hardware Reboot by reset pin (if soft reboot down work)
                </div>
              </div>
            </div>
            <div class="col-12 col-md-3 mt-4 mt-md-0" v-if="data">
              <div class="card mb-4">
                <div class="card-body">
                  <div class="ms-2">Controller info:</div>
                  <ul>
                    <li>CPU: {{ data.cpu }}</li>
                    <li>OS: {{ data.os }}</li>
                    <li>Release: {{ data.release }}</li>
                    <li>Hostname: {{ data.hostname }}</li>
                    <li>CPU temperature: {{ temperature.temperature }}</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-9" v-if="!empty">
          <v-chart class="chart mt-4 border pt-3" :option="option"/>
        </div>
      </div>
    </div>
    <loading-component v-else></loading-component>
  </admin-layout>
</template>

<script setup lang="ts">
import AdminLayout from "@/views/Layout/AdminLayout.vue";
import {use} from "echarts/core";
import {ref, onMounted} from "vue";
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
  MarkLineComponent,
  MarkAreaComponent,
  GraphicComponent
} from "echarts/components";
import VChart, {THEME_KEY} from "vue-echarts";
import axios from "axios";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import SuccessModal from "@/components/Modals/SuccessModal.vue";
import {useModal} from "@/composables/useModal";

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
  MarkLineComponent,
  GraphicComponent,
  MarkAreaComponent
]);

const option = ref({
  grid: {
    left: 80,
    right: 80,
    bottom: 20,
    top: 40,
    containLabel: true
  },
  title: {
    text: "Temperature",
    left: "center"
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
  ]
});
const data = ref([]);
const loading = ref(true);
const modal = useModal()
const temperature = ref('')
const empty = ref(true)

onMounted(() => {
  getData();
});

async function getData() {
  loading.value = true;
  await axios.get('/api/controller/getData')
    .then((response) => {
      data.value = response.data.data
      temperature.value = response.data.temperature
      if (response.data.options.line) {
        option.value.series.push(response.data.options.line)
        option.value.xAxis = response.data.options.xAxis
        empty.value = false
      }
    })
    .catch(() => {
      empty.value = true
    })
    .finally(() => {
      loading.value = false
    })
}

function turnOffModal() {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'Controller will be turn off! Connection with controller will be lost',
      subTitle: 'Are you sure?',
      function: async () => {
        await turnOff()
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

function softRebootModal() {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'Controller software/hardware will be reboot by bash "reboot"!<br>Connection with controller will be lost for 2 minutes',
      subTitle: 'Are you sure?',
      function: async () => {
        await softReboot()
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

function hardRebootModal() {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'Controller software/hardware will be reboot by bash "reboot"!<br>Connection with controller will be lost for 2 minutes',
      subTitle: 'Are you sure?',
      function: async () => {
        await hardReboot()
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

async function turnOff() {
  await axios.get('/api/controller/powerOff')
}

async function softReboot() {
  await axios.get('/api/controller/softReboot')
}

async function hardReboot() {
  await axios.get('/api/controller/hardReboot')
}
</script>
<style scoped>
.chart {
  height: 400px;
}
</style>
