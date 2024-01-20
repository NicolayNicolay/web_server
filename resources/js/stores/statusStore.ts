import {defineStore} from 'pinia'
import axios from "axios";

export const statusStore = defineStore('status', {
  state: () => {
    return {
      status: '',
    }
  },
  actions: {
    async checkStatus() {
      return new Promise((resolve, reject) => {
        axios.get('/api/server/getStatus')
          .then((response) => {
            this.status = response.data;
            resolve('');
          })
          .catch((error) => {
            reject(error);
          });
      });
    }
  }
});
