<template>
  <WhiteBox>
    <WhiteBoxHeading class="p-6 flex">
      <h2 class="text-xl font-medium grow">Password</h2>
      <button
        v-show="!enableChangePassword"
        @click="enableChangePassword = !enableChangePassword"
        class="rounded-full border border-gray-200 hover:bg-gray-100 py-1 w-[28px] h-[28px] flex items-center justify-center"
      >
        <svg-vue icon="edit" class="h-4 w-4" />
      </button>
    </WhiteBoxHeading>
    <WhiteBoxContent class="p-6">
      <div v-show="!enableChangePassword">
        <h3 class="text-lg text-red-700 font-medium">Password has been set</h3>
        <p>Choose a strong, unique password that’s at least 8 characters long.</p>
      </div>

      <div v-show="enableChangePassword">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-group mb-4">
            <label for="">Password</label>
            <input type="password" class="form-control" v-model="password.password" />
            <base-field-error v-if="errorChangingPassword">
              {{ errorChangingPassword }}
            </base-field-error>
          </div>
          <div class="form-group mb-4">
            <label for="">Confirm Password</label>
            <input type="password" class="form-control" v-model="password.password_confirmation" />
          </div>
        </div>

        <div class="btn-group-cta">
          <button :disabled="loading" @click="handleChangePassword" type="button" class="btn-primary">Update</button>
          <button @click="enableChangePassword = !enableChangePassword" type="button" class="btn-cancel">Cancel</button>
        </div>
      </div>
    </WhiteBoxContent>
  </WhiteBox>
</template>

<script>
import BaseFieldError from '@/components/BaseFieldError.vue';
import WhiteBox from '@/components/shared/WhiteBox.vue';
import WhiteBoxHeading from '@/components/shared/WhiteBoxHeading.vue';
import WhiteBoxContent from '@/components/shared/WhiteBoxContent.vue';

export default {
  components: { BaseFieldError, WhiteBox, WhiteBoxHeading, WhiteBoxContent },
  data: () => {
    return {
      loading: false,
      enableChangePassword: false,
      errorChangingPassword: '',
      password: {
        password: '',
        password_confirmation: ''
      }
    };
  },
  props: {
    profile: [Object]
  },
  methods: {
    async handleChangePassword() {
      this.loading = true;
      this.$util
        .post(`user/change-password/${this.profile.id}`, this.password)
        .then((response) => {
          this.enableChangePassword = !this.enableChangePassword;
          this.password.password = '';
          this.password.password_confirmation = '';
          Toast.fire('Your password was changed successfully.', '', 'success');
        })
        .catch((error) => {
          if (error.response) {
            console.log(error.response);
            this.errorChangingPassword = error.errors.password[0];
          }
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>

<style></style>
