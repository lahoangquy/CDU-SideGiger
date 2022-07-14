<template>
  <ViewDashboardLayout>
    <h1 class="dashboard__heading">Manage Projects</h1>
    <ListProject />
  </ViewDashboardLayout>
</template>

<script>
import ViewDashboardLayout from '@/Views/ViewDashboardLayout.vue';
import ListProject from './ListProject.vue';
export default {
  components: { ListProject, ViewDashboardLayout },
  computed: {
  },
  created() {
  }
};
</script>

<style lang="scss">
.dashboard {
  &__heading {
    @apply text-2xl font-semibold mb-8;
  }

  .tabs-wrapper {
    @apply mb-4 border-b border-gray-200 dark:border-gray-700;

    ul {
      li {
        button {
          @apply inline-block py-4 px-4 text-sm font-medium text-center text-gray-500 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300;

          &.active {
            border-color: #1c64f2;
            color: #1c64f2;
          }
        }
      }
    }
  }

  .tabpanel {
    @apply pt-6 pb-[100px];
  }
}

.btn-group-cta {
  @apply flex flex-col sm:flex-row gap-3 mt-5;
  .btn {
    &-primary {
      @apply mb-2 md:mb-0 text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-full text-sm px-5 py-2.5 text-center;

      &.btn-outline {
        @apply bg-transparent bg-none border border-blue-500 text-blue-500;
      }
    }
    &-cancel {
      @apply border border-gray-400 text-black font-medium rounded-full text-sm px-5 py-2.5 text-center;
    }
  }
}
</style>
