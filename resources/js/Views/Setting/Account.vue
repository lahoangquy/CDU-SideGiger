<template>
  <WhiteBox>
    <WhiteBoxHeading class="p-6 flex">
      <div class="grow">
        <h2 class="text-xl font-medium">Account</h2>
      </div>
      <button
        v-show="!enableChangeAccount"
        @click="enableChangeAccount = !enableChangeAccount"
        class="rounded-full border border-gray-200 hover:bg-gray-100 py-1 w-[28px] h-[28px] flex items-center justify-center"
      >
        <svg-vue icon="edit" class="h-4 w-4" />
      </button>
    </WhiteBoxHeading>
    <WhiteBoxContent class="p-6">
      <div v-show="!enableChangeAccount">
        <div class="mb-4">
          <p class="font-medium">Name</p>
          <p class="text-gray-500">{{ profile.name }}</p>
        </div>
        <div class="mb-4">
          <p class="font-medium">Email</p>
          <p class="text-gray-500">{{ profile.email }}</p>
        </div>
        <div class="mb-4">
          <p class="font-medium">Phone</p>
          <p class="text-gray-500">{{ profile.phone }}</p>
        </div>
        <template v-if="user.role === 'poster'">
          <div class="mb-4">
            <p class="font-medium">Department</p>
            <p class="text-gray-500">{{ profile.department }}</p>
          </div>
        </template>
        <template v-else>
          <div class="mb-4">
            <p class="font-medium">Course Name</p>
            <p class="text-gray-500">{{ profile.course_name }}</p>
          </div>
          <div class="mb-4">
            <p class="font-medium">Student ID</p>
            <p class="text-gray-500">{{ profile.student_id }}</p>
          </div>
        </template>
      </div>
      <div v-show="enableChangeAccount">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-group mb-4">
            <label for="">First Name</label>
            <input type="text" class="form-control" v-model="profile.first_name" />
          </div>
          <div class="form-group mb-4">
            <label for="">First Name</label>
            <input type="text" class="form-control" v-model="profile.last_name" />
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div v-if="user.role === 'tasker'" class="form-group mb-4">
            <label for="">Course Name</label>
            <input type="email" class="form-control" v-model="profile.course_name" />
          </div>
          <div class="form-group mb-4">
            <label for="">Phone#</label>
            <input type="text" class="form-control" v-model="profile.phone" />
          </div>
        </div>
        <template v-if="user.role === 'poster'">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group mb-4">
              <label for="">Department</label>
              <input type="text" class="form-control" v-model="profile.department" />
            </div>
          </div>
        </template>

        <div class="btn-group-cta">
          <button @click="handleUpdateAccount" type="button" class="btn-primary">Update</button>
          <button @click="enableChangeAccount = !enableChangeAccount" type="button" class="btn-cancel">Cancel</button>
        </div>
      </div>
    </WhiteBoxContent>
  </WhiteBox>
</template>

<script>
import WhiteBox from '@/components/shared/WhiteBox.vue';
import WhiteBoxHeading from '@/components/shared/WhiteBoxHeading.vue';
import WhiteBoxContent from '@/components/shared/WhiteBoxContent.vue';

export default {
  components: { WhiteBox, WhiteBoxHeading, WhiteBoxContent },
  data: () => {
    return {
      loading: false,
      enableChangeAccount: false
    };
  },
  props: {
    profile: [Object]
  },
  computed: {
    user() {
      return this.$util.options.auth || {};
    }
  },
  methods: {
    async handleUpdateAccount() {
      this.loading = true;
      this.$util
        .post(`user/${this.profile.id}`, this.profile)
        .then((response) => {
          this.enableChangeAccount = !this.enableChangeAccount;
          this.$emit('update-profile', response.user);
          Toast.fire(response.message, '', 'success');
        })
        .catch((error) => {
          if (error.response) {
            console.log(error.response);
          }
        })
        .finally(() => (this.loading = false));
    }
  }
};
</script>
