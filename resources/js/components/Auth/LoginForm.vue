<template>
  <div class="w-full h-screen md:max-w-[560px] mx-auto flex flex-col justify-center items-center px-4">
    <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-8 text-center">Sign in to your account</h3>
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
      <BaseAlert v-show="alertMessage" id="register-error-alert" type="error">
        {{ alertMessage }}
      </BaseAlert>
      <form @submit.prevent="handleLogin" class="p-6 space-y-6 lg:px-8 sm:pb-6 xl:pb-8 md:min-w-[460px]">
        <div class="form-group">
          <label for="email">Your email</label>
          <input type="email" v-model="login.email" id="email" class="form-control" placeholder="name@company.com" required />
        </div>
        <div class="form-group">
          <label for="password">Your password</label>
          <input type="password" v-model="login.password" id="password" placeholder="••••••••" class="form-control" required />
        </div>
        <div class="flex justify-between">
          <div class="flex items-start">
            <div class="flex items-center h-5">
              <input
                id="remember"
                aria-describedby="remember"
                type="checkbox"
                class="
                  w-4
                  h-4
                  bg-gray-50
                  rounded
                  border border-gray-300
                  focus:ring-3 focus:ring-blue-300
                  dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800
                "
              />
            </div>
            <div class="ml-3 text-sm">
              <label for="remember" class="font-medium text-gray-900 dark:text-gray-300">Remember me</label>
            </div>
          </div>
          <a href="/password/reset" class="text-sm text-blue-700 hover:underline dark:text-blue-500">Lost Password?</a>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
        <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
          Don't already have an account? <a href="/register" class="text-blue-700 hover:underline dark:text-blue-500">Create account</a>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BaseAlert from '@/components/BaseAlert.vue';
export default {
  components: { BaseAlert },
  data() {
    return {
      alertMessage: '',
      login: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    handleLogin() {
      this.$util.post('login', this.login, {
        done: (response) => {
          if (response.success == true) {
            window.location.href = '/';
          }
        },
        error: (error) => {
          if (error.message) {
            this.alertMessage = error.message;
          }
        }
      });
    }
  }
};
</script>

<style></style>
