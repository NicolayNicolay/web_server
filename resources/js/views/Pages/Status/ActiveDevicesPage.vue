<template>
  <admin-layout>
    <div class="row" v-if="!loading">
      <div class="col-12 mb-4">
        <button class="btn btn-primary me-sm-4 mt-2" @click.prevent="getData">Refresh info</button>
      </div>
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
                    <li v-if="item.memory">
                      Memory: {{ item.memory }}
                    </li>
                    <li v-if="item.motherboard">
                      Motherboard: {{ item.motherboard }}
                    </li>
                    <li v-if="item.switch">
                      Switch: {{ item.switch }}
                    </li>
                    <li v-if="item.expander">
                      Expander: {{ item.expander }}
                    </li>
                    <li v-if="item.tsensor">
                      Tsensor: {{ item.tsensor }}
                    </li>
                    <li v-if="item.uart">
                      UART: {{ item.uart }}
                    </li>
                    <li v-if="item.fan">
                      FAN: {{ item.fan }}
                    </li>
                    <li v-if="item.bottom">
                      Bottom: {{ item.bottom }}
                    </li>
                    <li v-if="item.top">
                      Top: {{ item.top }}
                    </li>
                    <li v-if="item.housing">
                      Housing: {{ item.housing }}
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
          <div class="col-12 col-sm-6" v-if="data.devices">
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
                  <td><span v-if="item.num">{{ item.num }}</span></td>
                  <td :class="item.cpus ? item.cpus.class : ''"><span v-if="item.cpus">{{ item.cpus.value }}</span></td>
                  <td><span v-if="item.Carrierboard">{{ item.Carrierboard }}</span></td>
                  <td><span v-if="item.Expander">{{ item.Expander }}</span></td>
                  <td><span v-if="item.Tsensor">{{ item.Tsensor }}</span></td>
                  <td><span v-if="item.UART">{{ item.UART }}</span></td>
                  <td><span v-if="item.Memory">{{ item.Memory }}</span></td>
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
import {onMounted, ref} from "vue";

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


onMounted(() => {
  getData();
})

//Functions
async function getData() {
  loading.value = true;
  await axios.get('/api/status/getActiveDevices')
    .then((response) => {
      data.value = response.data;
    })
    .catch(() => {
    })
    .finally(() => {
      loading.value = false;
    })
}

function inventoryNow() {
  loading.value = true;
  axios.get('/api/server/inventory').then(() => {
    getData();
  })
    .catch(() => {
    })
}
</script>
