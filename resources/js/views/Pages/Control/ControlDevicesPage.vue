<template>
  <admin-layout>
    <div class="row" v-if="!loading">
      <div class="col-12 mb-4"><button class="btn btn-primary me-sm-4 mt-2" @click.prevent="rebootAllModal">
          Reboot all carrierboards with its components (CPUs, LAN, USB)
        </button>
        <button class="btn btn-primary mt-2">Write flash memory (MB): Part number, Revision, Serial, Mfr.date</button>
      </div>
      <div class="col-12 col-xl-6" v-for="(item, index) in data" :key="index">
        <div class="card mb-4">
          <div class="card-body overflow-x-scroll">
            <h5 class="card-title text-center mb-0">
              Motherboard {{ index }} ({{ item.motherboard.name }})<br>
              {{ item.motherboard.sub_name }}
            </h5>
            <div class="table-responsive mt-3">
              <table class="table table-bordered table-hover text-center mt-3 mb-0 ">
                <tbody>
                <tr>
                  <td>+12V carrierboards status</td>
                  <td>+5V CPUs status</td>
                  <td>+3.3V carrierboards status</td>
                  <td>+3.3V standby voltage</td>
                  <td>+3.3V main voltage</td>
                  <td>Hotplug status</td>
                  <td>Active faults</td>
                </tr>
                <tr>
                  <td class="table-success">{{ item.motherboard.el_v_carrierboards_status }}</td>
                  <td class="table-success">{{ item.motherboard.v_cpu_status }}</td>
                  <td class="table-success">{{ item.motherboard.three_v_carrierboards_status }}</td>
                  <td class="table-success">{{ item.motherboard.three_v_standby_voltage }}</td>
                  <td class="table-success">{{ item.motherboard.three_v_main_voltage }}</td>
                  <td class="table-success">{{ item.motherboard.hotplug_status }}</td>
                  <td class="table-success">{{ item.motherboard.faults }}</td>
                </tr>
                </tbody>
              </table>
            </div>
            <div class="table-responsive mt-4">
              <table class="table table-bordered table-hover text-center mb-0 ">
                <thead class="table-light">
                <tr>
                  <th scope="col">CPUs num</th>
                  <th scope="col">Insert status</th>
                  <th scope="col">+5v CPUs status</th>
                  <th scope="col">+5v CPUs voltage, V</th>
                  <th scope="col">+5v CPUs power, W</th>
                  <th scope="col">Carrierboard switch reset</th>
                  <th scope="col">Carrierboard USB hub reset</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="cb in item.carrierboards">
                  <td class="">CPU carrierboard {{ cb['placement'] }}</td>
                  <td class="table-success">{{ cb['insert_status'] }}</td>
                  <td class="table-success">{{ cb['5v_cpu_status'] }}</td>
                  <td class="table-success">{{ cb['5v_cpu_voltage'] }}</td>
                  <td class="table-success">{{ cb['5v_cpu_power'] }}</td>
                  <td class="table-btn-wrapper">
                    <button class="btn btn-sm btn-primary d-flex align-items-center" @click.prevent="switchResetModal(cb['id'])">
                      <power-icon></power-icon>
                      Reboot
                    </button>
                  </td>
                  <td class="table-btn-wrapper">
                    <button class="btn btn-sm btn-primary d-flex align-items-center" @click.prevent="hubResetModal(cb['id'])">
                      <power-icon></power-icon>
                      Reboot
                    </button>
                  </td>
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
import {onMounted, ref} from "vue";
import {useModal} from "@/composables/useModal";
import axios from "axios";
import SuccessModal from '@/components/Modals/SuccessModal.vue'
import LoadingComponent from "@/components/System/LoadingComponent.vue";
import AdminLayout from "@/views/Layout/AdminLayout.vue";
import PowerIcon from "@/components/Icons/PowerIcon.vue";

const data = ref([]);
const loading = ref(true);
const modal = useModal()

onMounted(() => {
  getData();
});

//Functions
async function getData() {
  loading.value = true;
  await axios.get('/api/control/getMbCbData')
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

function rebootAllModal() {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'Reboot all carrierboards with its components (CPUs, LAN, USB)',
      subTitle: 'Are you sure?',
      function: async () => {
        await rebootAll()
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

function switchResetModal(id: number) {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'CPUs ' + id + ' network will reboot and are unavailable for 1 minute!',
      subTitle: 'Are you sure?',
      function: async () => {
        await switchReset(id)
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

function hubResetModal(id: number) {
  modal.open({
    component: SuccessModal,
    modelValue: {
      title: 'CPUs ' + id + ' USB HUB will reboot and Force Recovery Mode are unavailable for 1 minute!',
      subTitle: 'Are you sure?',
      function: async () => {
        await hubReset(id)
      },
      reloadFunction: async () => {
        await getData()
      }
    }
  })
}

async function rebootAll() {
  await axios.get('/api/control/rebootAllCB')
}

async function switchReset(id: number) {
  await axios.get('/api/control/rebootSwitch/' + id)
}

async function hubReset(id: number) {
  await axios.get('/api/control/rebootUsb/' + id)
}
</script>
<style>
td {
  display: table-cell;
  vertical-align: middle
}

.table-btn-wrapper {
  text-align: -webkit-center;
}
</style>
