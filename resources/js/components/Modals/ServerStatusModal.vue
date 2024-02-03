<script setup lang="ts">
import {ref} from "vue";
import {useModal} from '@/composables/useModal'
import {useStatus} from "@/composables/useStatus";
import axios from "axios";

const {params, close} = useModal()
const {title} = params.modelValue
const {statusParams, checkStatus} = useStatus()
const data = statusParams.serverData
const error = ref({
  'message': '',
  'status': false
})

function inventoryNow() {
  axios.get('/api/server/inventory').then(() => {
    clearError()
    checkStatus()
  })
    .catch((error) => {
      setError(error.response.data.message)
    })
}

function turnOn() {
  axios.get('/api/server/on').then(() => {
    clearError()
    checkStatus()
    close();
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
</script>

<template>
  <div class="modal-body">
    <div class="modal-text mt-3">
      <div class="text-danger text-center fs-5 mb-2" v-if="error.status">Error, something went wrong</div>
      <div class="text-bg-danger mb-4">
        <div class="fw-bold p-2 text-center fs-5">SERVER IS OFF</div>
      </div>
      <!--    hello {{ title }}-->
      <div class="row pt-3">
        <div class="col-12 col-md-5">
          <button class="btn btn-success btn-lg p-2 fw-semibold w-100" @click.prevent="turnOn">
            Turn ON
          </button>
        </div>
        <div class="col-12 col-md-6 offset-md-1 mt-4 mt-md-0">
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
</template>
<style scoped lang="scss">
.modal {
  --bs-modal-width: 800px;
}
</style>
