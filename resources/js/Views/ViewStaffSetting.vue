<template>
  <ViewDashboardLayout>
    <Profile />
  </ViewDashboardLayout>
</template>

<script>
import Profile from '@/components/Staff/Profile.vue';
import ViewDashboardLayout from './ViewDashboardLayout.vue';
export default {
  components: { ViewDashboardLayout, Profile }
};
</script>
