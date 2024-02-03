<script setup lang="ts">
import {ref} from "vue";
import {useModal} from '@/composables/useModal'

const {params, close} = useModal()
const {title, subTitle} = params.modelValue

const error = ref({
  'message': '',
  'status': false
})

function success() {
  params.modelValue.function().then(() => {
    clearError()
    close()
    params.modelValue.reloadFunction()
  }).catch((error: { response: { data: { message: string; }; }; }) => {
    if (error.response.data) {
      setError(error.response.data.message)
    }
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
  <div class="modal-body pt-3 pb-3 text-center">
    <div class="h5 mb-4">
      <div class="text-danger" v-if="error.status">
        {{ error.message }}
      </div>
      <div class="mb-2" v-html="title"></div>
      {{ subTitle }}
    </div>
    <div class="d-flex justify-content-center pt-2 pb-4">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Закрыть">NO</button>
      <button type="button" class="btn btn-success ms-4" @click.prevent="success">YES</button>
    </div>
  </div>
</template>
<style scoped lang="scss">
.btn {
  --bs-btn-padding-x: 2rem;
}
</style>
