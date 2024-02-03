<template>
  <admin-layout>
    <div class="row" v-if="!loading">
      <div class="col-md-12">
        <div class="text-danger text-center fs-5 mb-2" v-if="error.status">
          {{ error.message }}
        </div>
        <div class="text-bg-success mb-4" :class="data.status.card_class" v-if="data.status">
          <div class="fw-bold p-2 text-center" style="font-size: 21px">SERVER IS {{ powerStatus }}</div>
        </div>
      </div>
      <div class="col-12 mt-4">
        <div class="row">
          <div class="col-6 col-md-3">
            <div class="btn-wrapper d-flex flex-column">
              <button class="btn btn-lg p-2 fw-semibold" :class="changeStatusClass[powerActiveState - 1]" @click.prevent="turnToggle">
                Turn {{ changeStatusText[powerActiveState - 1] }}
              </button>
              <div class="text mt-3" v-html="changeStatusSubText[powerActiveState - 1]"></div>
            </div>
          </div>
          <div class="col-6 col-md-3 offset-md-1" v-if="powerActiveState === 1">
            <div class="btn-wrapper d-flex flex-column">
              <button class="btn btn-primary btn-lg p-2 fw-semibold" @click.prevent="rebootNow">
                Reboot
              </button>
              <div class="text mt-3">
                The server will be rebooted shortly. All services will ba temporarily unavailable for approximately one minute during the reboot process.
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4 col-xl-3 mt-4 mt-md-0" :class="powerActiveState !== 1? 'offset-md-5 offset-xl-6': 'offset-md-1 offset-xl-2'">
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
        </div>
      </div>
    </div>
    <loading-component v-else></loading-component>
  </admin-layout>
</template>

<script lang="ts" setup>
import AdminLayout from "@/views/Layout/AdminLayout.vue";
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import axios from "axios";
import {onMounted, ref, watch} from "vue";
import {useStatus} from "@/composables/useStatus";

const {statusParams, checkStatus} = useStatus()
const data = ref([])
const loading = ref(true)
const powerStatus = ref('')
const changeStatusText = ref([
  'OFF',
  'ON',
])
const changeStatusClass = ref([
  'btn-danger',
  'btn-success',
])
const changeStatusSubText = ref([
  'The server will be shut down. Most services will be temporarily unavailable until the serve is powered back on.',
  'The server will be turned on',
])
const apiPower = ref([
  '/api/server/off',
  '/api/server/on',
])
const powerActiveState = ref(0)
const error = ref({
  'message': '',
  'status': false
})

watch(statusParams, () => {
  if (statusParams.serverData.status.value.toUpperCase() != powerStatus.value) {
    getData()
  }
})

onMounted(() => {
  getData();
})

//Functions
async function getData() {
  loading.value = true;
  await axios.get('/api/control/getMainPowerData')
    .then((response) => {
      clearError()
      data.value = response.data;
      powerStatus.value = data.value.status.value.toUpperCase();
      powerActiveState.value = data.value.status.state;
    })
    .catch((error) => {
      setError(error.response.data.message)
    }).finally(() => {
      loading.value = false;
    })
}

function turnToggle() {
  loading.value = true;
  let api = apiPower.value[powerActiveState.value - 1];
  axios.get(api).then(() => {
    clearError()
  })
    .catch((error) => {
      setError(error.response.data.message)
    }).finally(() => {
    checkStatus()
  })
}

function inventoryNow() {
  loading.value = true;
  axios.get('/api/server/inventory').then(() => {
    getData();
  })
    .catch((error) => {
      setError(error.response.data.message)
    })
}

function clearError() {
  error.value.status = false
  error.value.message = ''
}

function setError(mess: string) {
  error.value.status = true
  error.value.message = mess
}

function rebootNow() {
  loading.value = true;
  axios.get('/api/server/reboot').then(() => {
    getData();
  })
    .catch((error) => {
      setError(error.response.data.message)
    }).finally(() => {
    loading.value = false;
  })
}
</script>
