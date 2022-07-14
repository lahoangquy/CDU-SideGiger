<template>
  <div class="container px-4 mt-12">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
      <StaffSideBarDashboard v-if="showSidebar" :role="user.role" />
      <main class="col-span-4">
        <slot />
      </main>
    </div>
  </div>
</template>

<script>
import StaffSideBarDashboard from './StaffSideBarDashboard.vue';
export default {
  components: { StaffSideBarDashboard },
  props: {
    showSidebar: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    user() {
      return this.$util.options.auth || {};
    }
  }
};
</script>
