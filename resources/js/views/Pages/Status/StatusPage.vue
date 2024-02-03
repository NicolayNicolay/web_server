<template>
  <admin-layout>
    <div class="row" v-if="!loading">
      <div class="col-md-3 col-xxl-2">
        <div class="mb-4">
          <div class="card" :class="data.status.card_class" v-if="data.status">
            <div class="card-header fw-semibold">Power status:</div>
            <div class="card-body">
              <div class="card-text">
                <div class="text-center fw-bold">Power {{ powerStatus }}</div>
              </div>
            </div>
          </div>
          <div class="help-text small text-center mt-1" v-html="workedTiming"></div>
        </div>


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

        <div class="card mb-4" :class="(data.devices && data.devices.cpus_class) ? data.devices.cpus_class: ''">
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
      <div class="col-md-9 col-xxl-10">
        <div class="row">
          <div class="col-md-12 col-xxl-6">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title text-center mb-0">Motherboards status</h5>
                <div class="d-none d-sm-block position-absolute end-0 top-0 pe-3 pt-2">
                  <div class="btn btn-sm btn-primary" @click.prevent="initDevices">Init MB devices</div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-hover text-center mt-3 mb-0" v-if="data.motherboards">
                    <thead class="table-light small">
                    <tr>
                      <th scope="col"></th>
                      <th scope="col" v-for="item in data.motherboards">{{ item.name }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td class="small fw-semibold">P/n</td>
                      <td v-for="item in data.motherboards">{{ item.sub_name }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">Overheat limit</td>
                      <td v-for="item in data.motherboards">{{ item.overheat_limit }} C</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">FANs installed</td>
                      <td v-for="item in data.motherboards">{{ item.fans_installed }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">FANs mode</td>
                      <td v-for="item in data.motherboards">{{ item.fans_installed }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">FANs fault min speed</td>
                      <td v-for="item in data.motherboards">{{ item.fans_fault_min_speed }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">FANs auto min PWM</td>
                      <td v-for="item in data.motherboards">{{ item.fans_auto_min_pwm }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">Temperature low/high/latch</td>
                      <td v-for="item in data.motherboards">{{ item.temperatures }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">Temperature start AUTO</td>
                      <td v-for="item in data.motherboards">{{ item.temperature_start_auto }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">Temperature operating AUTO</td>
                      <td v-for="item in data.motherboards">{{ item.temperature_operating_auto }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">MB temperature</td>
                      <td v-for="item in data.motherboards">{{ item.temperature_mb }}</td>
                    </tr>
                    <tr>
                      <td class="small fw-semibold">MB faults</td>
                      <td v-for="item in data.motherboards">{{ item.faults }}</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-xxl-6">
            <div class="card mb-4">
              <div class="card-body overflow-x-scroll">
                <h5 class="card-title text-center mb-0">Carrierboards status</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-hover text-center mt-3 mb-0" v-if="data.carrierboards">
                    <thead class="table-light small">
                    <tr>
                      <th scope="col">Num</th>
                      <th scope="col">Position (CB-X-Y, X-MB num, Y-CB slot)</th>
                      <th scope="col">P/n, Rev., S/n, Date</th>
                      <th scope="col">CPUs inserted</th>
                      <th scope="col">CPUs status on</th>
                      <th scope="col">Faults</th>
                      <th scope="col">Temp</th>
                      <th scope="col">Overheat limit</th>
                      <th scope="col">+5v CPUs status</th>
                      <th scope="col">+5v CPUs voltage, V</th>
                      <th scope="col">+5v CPUs power, W</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in data.carrierboards">
                      <td class="small fw-semibold">{{ item.num }}</td>
                      <td>{{ item.placement }}</td>
                      <td>{{ item.sub_name }}</td>
                      <td>{{ item.inserted }}</td>
                      <td :class="item.status.class">{{ item.status.value }}</td>
                      <td>{{ item.faults }}</td>
                      <td>{{ item.temperature }}</td>
                      <td>{{ item.overheat_limit }}</td>
                      <td :class="item.v_cpu_status.class">{{ item.v_cpu_status.value }}</td>
                      <td :class="item.v_cpu_voltage.class">{{ item.v_cpu_voltage.value }}</td>
                      <td :class="item.v_cpu_power.class">{{ item.v_cpu_power.value }}</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
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
import {onMounted, ref, watch} from "vue";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import {useStatus} from "@/composables/useStatus";

const {statusParams} = useStatus()
const data = ref([])
const loading = ref(true)
const powerStatus = ref('')
const workedTiming = ref('')

onMounted(() => {
  getData();
})

watch(statusParams, () => {
  getData()
})

//Functions
async function getData() {
  loading.value = true;
  await axios.get('/api/status/getData')
    .then((response) => {
      data.value = response.data;
      powerStatus.value = data.value.status.value.toUpperCase();
      getWorkedTiming();
    })
    .catch(() => {
    })
    .finally(() => {
      loading.value = false;
    })
}

function getWorkedTiming() {
  if (data.value.uptime && data.value.uptime.status) {
    workedTiming.value = 'Uptime: ' + data.value.uptime.timing + ' since<br>' + data.value.uptime.date;
  } else {
    workedTiming.value = 'Last working time: ' + data.value.uptime.date;
  }
}

function inventoryNow() {
  loading.value = true;
  axios.get('/api/server/inventory').then((response) => {
    getData();
  })
    .catch(() => {
    })
}

function initDevices() {
  axios.get('/api/server/initDevices').then((response) => {
    getData();
  })
    .catch(() => {
    })
}
</script>
