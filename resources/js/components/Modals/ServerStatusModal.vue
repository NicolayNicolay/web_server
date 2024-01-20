<script setup lang="ts">
import {useModal} from '@/composables/useModal'

const {params, close} = useModal()
const {title} = params.modelValue
</script>

<template>
  <div class="modal-body">
    <div class="modal-text mt-3">
      <div class="text-bg-danger mb-4">
        <div class="fw-bold p-2 text-center fs-5">SERVER IS OFF - 100C (Overheat shutdown)</div>
      </div>
      <!--    hello {{ title }}-->
      <div class="row pt-3">
        <div class="col-12 col-md-5">
          <div class="btn btn-success btn-lg p-2 fw-semibold w-100">
            Turn ON
          </div>
        </div>
        <div class="col-12 col-md-6 offset-md-1 mt-4 mt-md-0">
          <div class="card mb-4">
            <div class="card-header fw-semibold">Summary devices:</div>
            <div class="card-body">
              <div class="card-text">
                <ul>
                  <li>Motherboards: 2</li>
                  <li>Carrierboards: 14</li>
                  <li>CPUs: 56</li>
                  <li>PSUs: 3</li>
                </ul>
              </div>
              <div>
                <button type="button" class="btn btn-primary w-100">Inventory now</button>
              </div>
            </div>
            <div class="card-footer text-body-secondary">
              <div class="help-text small text-center">UPD: 123</div>
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
