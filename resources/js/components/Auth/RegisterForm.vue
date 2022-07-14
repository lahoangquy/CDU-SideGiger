<template>
  <main class="w-full md:max-w-2xl mx-auto px-4 py-14">
    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-12 text-center">Sign up to our platform</h1>
    <form @submit.prevent="handleSubmit">
      <BaseAlert v-show="errors" id="register-error-alert" type="error">
        {{ errors ? errors.message : '' }}
      </BaseAlert>

      <div class="flex flex-col md:flex-row items-start md:items-center gap-4 md:gap-6">
        <div class="checkbox">
          <input id="option-1" type="radio" v-model="register.type" value="tasker" aria-labelledby="option-1" aria-describedby="option-1" />
          <label for="option-1"> I am signing up as a CDU Student </label>
        </div>
        <div class="checkbox">
          <input id="option-2" type="radio" v-model="register.type" value="poster" aria-labelledby="option-2" aria-describedby="option-2" />
          <label for="option-2"> I am signing up as a Staff </label>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" v-model="register.first_name" class="form-control" required />
          <span v-if="errors && errors.first_name" class="text-sm text-red-400 font-light">
            {{ errors.first_name[0] }}
          </span>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text" v-model="register.last_name" class="form-control" required />
          <span v-if="errors && errors.last_name" class="text-sm text-red-400 font-light">
            {{ errors.last_name[0] }}
          </span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="email">Your email</label>
          <input type="email" v-model="register.email" class="form-control" placeholder="name@company.com" required />
          <span v-if="errors && errors.email" class="text-sm text-red-400 font-light">
            {{ errors.email[0] }}
          </span>
        </div>
        <div class="form-group">
          <label for="phone">Phone#</label>
          <input type="phone" v-model="register.phone" class="form-control" />
          <span v-if="errors && errors.phone" class="text-sm text-red-400 font-light">
            {{ errors.phone[0] }}
          </span>
        </div>
      </div>

      <div v-show="register.type === 'poster'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="department">Department</label>
          <input type="text" v-model="register.department" class="form-control" />
          <span v-if="errors && errors.department" class="text-sm text-red-400 font-light">
            {{ errors.department[0] }}
          </span>
        </div>
      </div>

      <div v-show="register.type === 'tasker'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="course_name">Course Name</label>
          <input type="text" v-model="register.course_name" class="form-control" />
          <span v-if="errors && errors.course_name" class="text-sm text-red-400 font-light">
            {{ errors.course_name[0] }}
          </span>
        </div>
        <div class="form-group">
          <label for="student_id">Student ID</label>
          <input type="text" v-model="register.student_id" class="form-control" />
          <span v-if="errors && errors.student_id" class="text-sm text-red-400 font-light">
            {{ errors.student_id[0] }}
          </span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="password">Your password</label>
          <input type="password" v-model="register.password" id="password" placeholder="••••••••" class="form-control" required />
          <span v-if="errors && errors.password" class="text-sm text-red-400 font-light">
            {{ errors.password[0] }}
          </span>
        </div>
        <div class="form-group">
          <label for="confirmation_password">Confirm password</label>
          <input
            type="password"
            v-model="register.password_confirmation"
            id="confirmation_password"
            placeholder="••••••••"
            class="form-control"
            required
          />
        </div>
      </div>

      <button :disabled="loading" type="submit" class="btn btn-primary">{{ loading ? 'Processing' : 'Submit' }}</button>
      <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
        Already have an account?
        <a href="/login" class="text-blue-700 hover:underline dark:text-blue-500">Sign In</a>
      </div>
    </form>
  </main>
</template>

<script>
import BaseAlert from '../BaseAlert.vue';
import ConfirmModal from '../ConfirmModal.vue';
export default {
  components: { BaseAlert, ConfirmModal },
  data: () => {
    return {
      loading: false,
      errors: null,
      register: {
        type: 'tasker',
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        department: '',
        course_name: '',
        student_id: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    async handleSubmit(e) {
      this.errors = null;
      this.loading = true;

      try {
        let response = await this.$util.post('register', this.register);
        this.showConfirmRegistered();
        this.resetRegisterForm();
      } catch (error) {
        if (error.response) {
          this.errors = error.errors;
          this.errors.message = error.message;
        }
      } finally {
        this.loading = false;
      }
    },
    resetRegisterForm() {
      let self = this;
      Object.keys(self.$data.register).forEach(function (key, index) {
        key === 'type' ? (self.$data.register[key] = 'tasker') : (self.$data.register[key] = '');
      });
    },
    showConfirmRegistered() {
      this.$swal('Congratulation!', 'An email sent to you. Please check your inbox and verify to be continue to use our platform.', 'success');
    }
  }
};
</script>

<style lang="scss">
.btn {
  @apply w-full text-sm px-5 py-2.5 text-center font-medium rounded-lg;

  &-primary {
    @apply text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800;
  }
}
form {
  @apply p-6 space-y-6 xl:pb-8 shadow-2xl rounded-md;
}
.form-group {
  label {
    @apply block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300;
  }

  .form-control {
    @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white;
  }
}
</style>
