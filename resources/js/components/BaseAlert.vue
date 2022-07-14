<template>
  <div :id="id" class="alert" :class="`alert-${type}`" role="alert">
    <svg-vue icon="warning-info" class="flex-shrink-0 w-5 h-5" />
    <div class="ml-3 text-sm font-medium text-red-700 dark:text-red-800">
      <slot />
    </div>
    <button
      type="button"
      class="btn-close"
      :data-collapse-toggle="id"
      aria-label="Close"
    >
      <span class="sr-only">Close</span>
      <svg-vue icon="close" class="w-5 h-5" />
    </button>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      default: 'my-alert'
    },
    type: {
      type: String,
      default: 'normal'
    }
  }
};
</script>

<style lang="scss" scoped>
.alert {
  @apply flex p-4 mb-4  rounded-lg;

  &-error {
    @apply bg-red-100 dark:bg-red-200;

    svg {
      @apply text-red-700 dark:text-red-800;
    }

    .btn-close {
      @apply ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-red-200 dark:text-red-600 dark:hover:bg-red-300;
    }
  }
}
</style>
