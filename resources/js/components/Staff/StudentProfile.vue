<template>
  <div>
    <div class="p-6">
      <div>
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
        <div class="mb-4">
          <p class="font-medium">Department</p> 
          <p class="text-gray-500" v-html="profile.department"></p>
        </div>
      </div> 
    </div>
  </div>
</template>

<script>

export default {
  data: () => {
    return {
      profile: {

      }
    };
  },
  methods: {
    updateProfile(data) {
      this.profile = data;
    }
  },
  props: {
    studentId: {
      type: Number,
      default: false
    },
  },
  created() {
    if (parseInt(this.studentId) > 0) {
      this.$util.get(`user/${this.studentId}`).then((response) => (this.profile = response.user));
    }
  }
};
</script>
