<template>
  <aside>
    <white-box-heading>
      <white-box-heading class="px-4 py-2">
        <h3 class="text-xl">Navigation</h3>
      </white-box-heading>
      <white-box-content class="px-4 py-4">
        <nav class="flex flex-col space-y-4">
          <a href="/dashboard/setting">Contact Info</a>
          <a href="/dashboard/manage-contract">All Contracts</a>
          <a v-if="role === 'tasker'" href="/dashboard/invited">List Invites Pending</a>
          <a v-if="role === 'tasker'" href="/dashboard/applicated">List Proposales Pending</a>
          <!-- <a v-if="role === 'tasker'" href="/dashboard/my-profile">My Profile</a> -->
          <!-- <a v-if="role === 'tasker'" href="/staff/dashboard/profile">Profile Setting</a> -->
          <a v-if="role === 'poster'" href="/staff/manage-project">Manage Projects</a>
        </nav>
      </white-box-content>
    </white-box-heading>
  </aside>
</template>

<script>
import WhiteBoxHeading from '../components/shared/WhiteBoxHeading.vue';
import WhiteBoxContent from '../components/shared/WhiteBoxHeading.vue';

export default {
  components: { WhiteBoxContent, WhiteBoxHeading, WhiteBoxContent },
  props: {
    role: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
aside {
  a {
    @apply text-sm hover:underline hover:text-blue-600;
  }
}
</style>
