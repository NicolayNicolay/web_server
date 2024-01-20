<template>
  <admin-layout>
    <div class="row" v-if="!loading">
      <div class="col-md-12 col-xxl-5" v-if="data.motherboards">
        <div class="card mb-4">
          <h5 class="card-title text-center mt-2 mb-2">Motherboards</h5>
          <div class="row g-0">
            <div class="col-12" :class="[(data.motherboards.length > 1) ? 'col-lg-6': '', key > 0? 'border-left': '']" v-for="(item, key) in data.motherboards" :key="key">
              <div class="card-header fw-semibold border-top rounded-0 text-center">
                {{ item.name }} Active devices
              </div>
              <div class="card-body">
                <div class="card-text">
                  <ul>
                    <li v-if="item.Memory">
                      Memory: {{ item.Memory }}
                    </li>
                    <li v-if="item.Motherboard">
                      Motherboard: {{ item.Motherboard }}
                    </li>
                    <li v-if="item.switch">
                      Switch: {{ item.switch }}
                    </li>
                    <li v-if="item.Expander">
                      Expander: {{ item.Expander }}
                    </li>
                    <li v-if="item.Tsensor">
                      Tsensor: {{ item.Tsensor }}
                    </li>
                    <li v-if="item.UART">
                      UART: {{ item.UART }}
                    </li>
                    <li>
                      FAN: ADT7173ARQZ-1 RL
                    </li>
                    <li v-if="item.Bottom">
                      Bottom: {{ item.Bottom }}
                    </li>
                    <li v-if="item.Top">
                      Top: {{ item.Top }}
                    </li>
                    <li v-if="item.Housing">
                      Housing: {{ item.Housing }}
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row g-0">
          <div class="col-12 col-sm-6 pe-sm-4">
            <div class="card mb-4">
              <div class="card-header fw-semibold">Summary devices:</div>
              <div class="card-body">
                <div class="card-text" v-if="data.devices && data.devices.summary_devices">
                  <ul>
                    <li>Motherboards: {{ data.devices.summary_devices.Motherboard }}</li>
                    <li>Carrierboards: {{ data.devices.summary_devices.Carrierboard }}</li>
                    <li>CPUs: {{ data.devices.summary_devices.CPU }}</li>
                    <li>PSUs: {{ data.devices.summary_devices.PSU_FRU }}</li>
                  </ul>
                </div>
                <div>
                  <button type="button" class="btn btn-primary w-100" @click.prevent="inventoryNow">Inventory now</button>
                </div>
              </div>
              <div class="card-footer text-body-secondary">
                <div class="help-text small text-center">UPD: {{ data.inventory_time }}</div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="card" :class="(data.devices && data.devices.cpus_class) ? data.devices.cpus_class: ''">
              <div class="card-header fw-semibold">CPUs status:</div>
              <div class="card-body">
                <div class="card-text" v-if="data.devices && data.devices.cpus">
                  <ul>
                    <li>Inserted: {{ data.devices.cpus.Inserted }}</li>
                    <li>Powered: {{ data.devices.cpus.Powered }}</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-xxl-7">
        <div class="card mb-4">
          <div class="card-body overflow-x-scroll">
            <h5 class="card-title text-center mb-0">Carrierboards status</h5>
            <div class="table-responsive">
              <table class="table table-bordered table-hover text-center mt-3 mb-0 ">
                <thead class="table-light">
                <tr>
                  <th scope="col">Num</th>
                  <th scope="col">CPUs</th>
                  <th scope="col">Carrierboard</th>
                  <th scope="col">Expander</th>
                  <th scope="col">Tsensor</th>
                  <th scope="col">UART</th>
                  <th scope="col">Memory</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in data.carrierboards">
                  <td>{{ item.num }}</td>
                  <td :class="item.cpus.class">{{ item.cpus.value }}</td>
                  <td>{{ item.Carrierboard }}</td>
                  <td>{{ item.Expander }}</td>
                  <td>{{ item.Tsensor }}</td>
                  <td>{{ item.UART }}</td>
                  <td>{{ item.Memory }}</td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <loading-component v-else></loading-component>
  </admin-layout>
</template>

<script lang="ts" setup>
import AdminLayout from "@/views/Layout/AdminLayout.vue";
import axios from "axios";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import {useSidebar} from "@/composables/useSidebar";
import {onMounted, ref} from "vue";

// const {init} = useSidebar();
const sidebar = [
  {
    'name': 'Summary status',
    'url': '/',
  },
  {
    'name': 'Active devices',
    'url': '/status/activeDevices',
  },
  {
    'name': 'Active faults',
    'url': '/status/activeFaults',
  }
];
const data = ref([])
const loading = ref(true)

// init(sidebar);

onMounted(() => {
  getData();
})

//Functions
async function getData() {
  loading.value = true;
  await axios.get('/api/status/getActiveDevices')
    .then((response) => {
      data.value = response.data;
      console.log(data.value);
    })
    .catch(() => {
    })
    .finally(() => {
      loading.value = false;
    })
}

function inventoryNow() {
  loading.value = true;
  axios.get('/api/server/inventory').then((response) => {
    console.log(response.data);
    getData();
  })
    .catch(() => {
    })
}
</script>
