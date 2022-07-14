<template>
  <div>
    <div class="bg-slate-600 text-white">
      <div class="container flex justify-between items-center py-4 px-4">
        <div class="flex items-center space-x-6">
          <a href="/" class="font-extrabold">CDU SIDE GIGS</a>
        </div>
        <div v-if="!authenticated.id" class="hidden md:flex items-center space-x-6">
          <a href="/login" class="hover:text-gray-500">Log in </a>
          <a href="/register" class="btn-signup"> Create your profile</a>
        </div>
        <div v-else class="hidden md:flex items-center space-x-6">
          <Setting />
        </div>
        <button id="btn-toggle-menu" class="md:hidden">
          <svg-vue icon="menu" class="w-6 h-6" />
        </button>
      </div>
    </div>

    <!-- Login modal -->
    <Modal :show="showLoginModal" @close="showLoginModal = false" title="Log in to AirTasker">
      <div class="mb-4">
        <input @blur="$v.login.email.$touch()" type="text" v-model="login.email" class="form-control" placeholder="Email address" />
        <span v-if="$v.login.email.$error" class="text-sm text-red-700 font-light italic">This field is required</span>
      </div>
      <div class="mb-4">
        <input @blur="$v.login.password.$touch()" type="password" v-model="login.password" class="form-control" placeholder="********" />
        <span v-if="$v.login.password.$error" class="text-sm text-red-700 font-light italic">This field is required</span>
      </div>
      <button @click="handleLogin()" :disabled="$v.login.$invalid" :class="{ 'btn-disabled': $v.login.$invalid }" class="btn-submit">Log In</button>
      <a
        @click.prevent="
          showRestPasswordModal = true;
          showLoginModal = false;
        "
        class="text-blue-500 text-center block cursor-pointer"
      >
        Forgot password?
      </a>

      <hr class="my-12" />
      <div class="text-center">
        <p class="text-gray-500">Dont have an AirTasker account?</p>
        <button class="my-4 border border-red-500 px-6 py-1 rounded-full text-red-500 hover:bg-red-200">Sign Up</button>
      </div>
    </Modal>

    <!-- Forgot password modal -->
    <Modal :show="showRestPasswordModal" @close="showRestPasswordModal = false" title="Reset Password">
      <div class="mb-4">
        <input @blur="$v.resetPassword.email.$touch()" type="text" v-model="resetPassword.email" class="form-control" placeholder="Email address" />
        <span v-if="$v.resetPassword.email.$error" class="text-sm text-red-700 font-light italic">This field is required</span>
      </div>
      <button
        @click="handleResetPassword()"
        :disabled="$v.resetPassword.$invalid"
        :class="{ 'btn-disabled': $v.resetPassword.$invalid }"
        class="btn-submit"
      >
        Submit
      </button>
    </Modal>

    <ConfirmModal popupId="test" :showCloseButton="true" closeText="No Baby" @handle-confirm="test('test')"> What's going on man? </ConfirmModal>
  </div>
</template>

<script>
import Modal from './Modal.vue';
import { required, minLength, email } from 'vuelidate/lib/validators';
import ConfirmModal from './ConfirmModal.vue';
import Setting from './Auth/Setting.vue';
export default {
  name: 'Header',
  components: { Modal, ConfirmModal, Setting },
  data() {
    return {
      showLoginModal: false,
      showRestPasswordModal: false,
      login: {
        email: '',
        password: ''
      },
      resetPassword: {
        email: ''
      },
      register: {
        first_name: '',
        last_name: '',
        email: '',
        password: ''
      }
    };
  },
  computed: {
    authenticated() {
      return this.$util.options.auth || {};
    }
  },
  validations: {
    login: {
      email: {
        required,
        email,
        minLength: minLength(3)
      },
      password: {
        required,
        minLength: minLength(8)
      }
    },
    resetPassword: {
      email: {
        required,
        email,
        minLength: minLength(3)
      }
    }
  },
  methods: {
    toggleMenuMobile() {
      const menuMobile = document.querySelector('#mobile-menu');
      const btnMenuMobile = document.querySelector('#btn-toggle-menu');

      btnMenuMobile.addEventListener('click', () => {
        menuMobile.classList.toggle('hidden');
      });
    },
    handleLogin() {
      this.$v.$touch();
    },
    handleResetPassword() {
      this.$v.$touch();
    }
  },
  mounted() {
    this.toggleMenuMobile();
  }
};
</script>

<style lang="scss" scoped>
.btn-signup {
  @apply shadow rounded-full px-4 py-1.5 text-white font-bold bg-red-500 hover:bg-red-400 hover:text-white transition duration-300;
}
.btn-submit {
  @apply w-full my-4 border border-red-500 px-6 py-1.5 rounded-full bg-red-500 text-white hover:bg-red-600;
}
</style>
