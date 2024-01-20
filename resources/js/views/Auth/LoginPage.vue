<template>
  <div class="container-fluid">
    <div class="form-signin">
      <div class="card">
        <div class="card-body p-4">
          <form action="#" method="POST" @submit.prevent="authorize">
            <div class="logo">
              SMD
            </div>
            <hr>
            <div class="text-center"><h1 data-v-1cb5ce43="" class="h2 fw-bold">Authorization</h1>
              <div class="mb-3">
                Please log in
              </div>
            </div>
            <div class="alert alert-danger" v-if="error">{{ error }}</div>
            <div class="form-floating">
              <input type="email" id="floatingEmail" name="email" class="form-control" v-model="form.email" required>
              <label for="floatingEmail">E-mail</label>
            </div>
            <div class="form-floating">
              <input type="password" id="floatingPassword" class="form-control" name="password" required v-model="form.password">
              <label for="floatingPassword">Password</label></div>
            <div class="form-check mb-3">
              <input id="rememberInput" name="remember" class="form-check-input cursor-pointer" type="checkbox" value="0" v-model="form.remember">
              <label class="form-check-label cursor-pointer" for="rememberInput">Remember me</label>
            </div>
            <button type="submit" class="w-100 btn btn-lg btn-primary" :disabled="loading">
              Sing in
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import {authStore} from "@/stores/authStore";

export default {
  name: "LoginPage",
  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: true,
      },
      loading: false,
      error: null,
    }
  },
  methods: {
    authorize() {
      this.loading = true;
      axios.post('/api/login', this.form)
        .then(() => {
          // Check auth and redirect to homepage
          authStore()
            .checkAuth()
            .then(() => {
              this.$router.push({name: 'StatusPage'});
            })
            .catch(() => {
              alert('An error has occurred');
            });
        })
        .catch((error) => {
          if (error.response.status === 401) {
            this.error = error.response.data.message;
          } else {
            alert('An error has occurred');
          }
        })
        .finally(() => {
          this.loading = false;
        })
    }
  }
}
</script>

<style scoped>
</style>
