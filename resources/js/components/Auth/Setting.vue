<template>
  <div class="setting">
    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="setting-dropdown-btn" type="button">
      <span class="mr-1">Welcome {{ user.name }}</span>
      <svg-vue icon="caret-down" class="w-4 h-4" />
    </button>

    <!-- Dropdown menu -->
    <div id="dropdown" class="hidden">
      <ul class="py-1" aria-labelledby="dropdownButton">
        <li>
          <a :href="user.role === 'poster' ? '/staff/manage-project' : '/dashboard/manage-contract'">
            <svg-vue icon="view-grid" class="w-5 h-5" /><span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="/dashboard/setting">
            <svg-vue icon="setting" class="w-5 h-5" />
            <span>Account Settings</span>
          </a>
        </li>
        <li>
          <a href="#" @click.prevent="logout">
            <svg-vue icon="logout" class="w-5 h-5" />
            <span>Sign out</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    user() {
      return this.$util.options.auth || {};
    }
  },
  methods: {
    async logout() {
      await this.$util.post('logout');
      window.location.href = '/';
    }
  }
};
</script>

<style lang="scss">
.setting {
  &-dropdown-btn {
    @apply flex justify-between items-center py-2 pr-4 pl-3 w-full border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent;
  }

  #dropdown {
    @apply z-[999] w-44 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700;

    li {
      a {
        @apply flex items-center gap-2 py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white;
      }
    }
  }
}
</style>
