<template>
  <main class="w-full md:max-w-3xl mx-auto px-4 py-14">
    <form @submit.prevent="handleSubmit">
      <h3 class="text-xl font-medium text-gray-900 dark:text-white">
        Sign up to our platform
      </h3>
      <base-alert v-if="errors" id="register-error" type="error">
        {{ errors.message }}
      </base-alert>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input
            type="text"
            v-model="register.first_name"
            class="form-control"
            required
          />
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input
            type="text"
            v-model="register.last_name"
            class="form-control"
            required
          />
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="email">Your email</label>
          <input
            type="email"
            v-model="register.email"
            class="form-control"
            placeholder="name@company.com"
            required
          />
          <span
            v-if="errors && errors.errors.email"
            class="text-sm text-red-400 font-light"
            >{{ errors.errors.email[0] }}</span
          >
        </div>
        <div class="form-group">
          <label for="phone">Phone#</label>
          <input
            type="phone"
            v-model="register.phone"
            class="form-control"
            required
          />
          <span
            v-if="errors && errors.errors.phone"
            class="text-sm text-red-400 font-light"
            >{{ errors.errors.phone[0] }}</span
          >
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="department">Student ID</label>
          <input
            type="text"
            v-model="register.student_id"
            class="form-control"
            required
          />
        </div>
        <div class="form-group">
          <label for="affiliation">Course Name</label>
          <input
            type="text"
            v-model="register.course_name"
            class="form-control"
            required
          />
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-group">
          <label for="password">Your password</label>
          <input
            type="password"
            v-model="register.password"
            id="password"
            placeholder="••••••••"
            class="form-control"
            required
          />
          <span
            v-if="errors && errors.errors.password"
            class="text-sm text-red-400 font-light"
            >{{ errors.errors.password[0] }}</span
          >
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

      <button type="submit" class="btn btn-primary">Submit</button>
      <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
        Already have an account?
        <a
          href="/login"
          class="text-blue-700 hover:underline dark:text-blue-500"
          >Sign In</a
        >
      </div>
    </form>

    <ConfirmModal
      popupId="confirmRegister"
      :showCloseButton="false"
      @handle-confirm="closeConfirmationModal('confirmRegister')"
    >
      An email sent to you. Please check your inbox and verify to be continue to
      use our platform.
    </ConfirmModal>
  </main>
</template>

<script>
import BaseAlert from '../BaseAlert.vue';
import ConfirmModal from '../ConfirmModal.vue';
export default {
  components: { BaseAlert, ConfirmModal },
  data: () => {
    return {
      register: {
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        student_id: '',
        course_name: '',
        password: '',
        password_confirmation: ''
      },
      errors: null
    };
  },
  methods: {
    async handleSubmit() {
      try {
        const res = await axios.post(`/api/student/register`, this.register);
        this.resetRegisterForm();
        toggleModal('confirmRegister', true);
      } catch (error) {
        this.errors = error;
      }
    },
    closeConfirmationModal(modalId) {
      toggleModal(modalId, false);
    },
    resetRegisterForm() {
      let self = this;
      Object.keys(this.data.register).forEach(function (key, index) {
        self.data.register[key] = '';
      });
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
  @apply px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8 shadow-md rounded-md;
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
