<template>
  <admin-layout>
    <v-chart class="chart mt-4" :option="option"/>
  </admin-layout>
</template>
<script setup lang="ts">
import {use} from "echarts/core";
import {ref, provide} from "vue";
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
import AdminLayout from "@/views/Layout/AdminLayout.vue";

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
    left: "3%",
    right: "22%",
    bottom: 40,
    containLabel: true
  },
  title: {
    text: "Test Graph",
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
  xAxis: [
    {
      type: "category",
      boundaryGap: false,
      data: [
        "Aug 20",
        "Aug 27",
        "Sep 3",
        "Sep 10",
        "Sep 17",
      ]
    }
  ],
  yAxis: [
    {
      type: "value"
    }
  ],
  legend: {
    type: "scroll",
    data: [
      "test1",
      "test2",
      "test3",
    ],
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
  series: [
    {
      show: false,
      name: "test1",
      type: "line",
      // areaStyle: [],
      showSymbol: false,
      emphasis: {
        focus: "series"
      },
      color: "#4c8432",
      itemStyle: {
        "color": "#4c8432"
      },
      lineStyle: {
        "width": 2
      },
      data: [
        200,
        450,
        400,
        300,
        100
      ]
    },
    {
      show: false,
      name: "test2",
      type: "line",
      // areaStyle: [],
      showSymbol: false,
      emphasis: {
        focus: "series"
      },
      label: {
        color: "red"
      },
      color: "#ff0000",
      itemStyle: {
        color: "#ff0000"
      },
      lineStyle: {
        width: 2
      },
      data: [
        200,
        300,
        400,
        500,
        600
      ]
    },
    {
      show: false,
      name: "test3",
      type: "line",
      // areaStyle: [],
      showSymbol: false,
      emphasis: {
        focus: "series"
      },
      label: {
        color: "red"
      },
      color: "#1324e0",
      itemStyle: {
        color: "#1324e0"
      },
      lineStyle: {
        width: 2
      },
      data: [
        200,
        400,
        600,
        300,
        200
      ]
    }
  ]
});

</script>
<style scoped>
.chart {
  height: 400px;
}
</style>
