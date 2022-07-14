<template>
  <div class="tabs-wrapper">
    <ul class="flex flex-wrap -mb-px" role="tablist">
      <li v-for="(tab, index) in tabs" :key="index" role="presentation">
        <button type="button" @click="$emit('select-tab', tab.target)" :class="{ active: selectedTab === tab.target }">
          {{ tab.name }}
        </button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    tabs: {
      type: Array | Object,
      required: true
    },
    selectedTab: {
      type: String
    }
  },
  computed: {
    randomeElementId() {
      return '_' + Math.random().toString(36).substr(2, 9);
    }
  }
};
</script>

<style lang="scss" scoped>
.tabs-wrapper {
  @apply mb-4 border-b border-gray-200 dark:border-gray-700;

  ul {
    li {
      button {
        @apply inline-block py-4 px-4 text-sm font-semibold text-center text-gray-800 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-orange-500 dark:text-gray-400 dark:hover:text-gray-300;

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
</style>
