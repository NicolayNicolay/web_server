import {reactive} from 'vue'
import axios from "axios";

interface StatusParams {
  serverTitle: string
  serverStatus: string
  serverData: any
}

const statusParams = reactive<StatusParams>({
  serverStatus: '',
  serverTitle: 'Tegraserver monitoring and control',
  serverData: {}
})

async function checkStatus() {
  return new Promise((resolve, reject) => {
    axios.get('/api/server/getStatus')
      .then((response) => {
        statusParams.serverData = response.data;
        statusParams.serverStatus = 'SERVER IS ' + statusParams.serverData.status.value.toUpperCase();
        resolve('');
      })
      .catch((error) => {
        reject(error);
      });
  });
}

export const useStatus = () => {
  return {
    statusParams,
    checkStatus
  }
}
