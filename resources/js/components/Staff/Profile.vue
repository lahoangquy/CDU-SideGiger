<template>
  <div>
    <h1 class="dashboard__heading">Contact Info</h1>
    <Account :profile="profile" @update-profile="updateProfile" class="mb-8" />
    <Password :profile="profile" />
  </div>
</template>

<script>
import Account from '@/Views/Setting/Account.vue';
import Password from '@/Views/Setting/Password.vue';
export default {
  components: { Account, Password },
  data: () => {
    return {
      profile: {}
    };
  },
  methods: {
    updateProfile(data) {
      this.profile = data;
    }
  },

  created() {
    this.$util.get('user').then((response) => (this.profile = response));
  }
};
</script>
