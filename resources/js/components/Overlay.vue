<template>
  <div class="overlay"><slot /></div>
</template>

<script>
export default {
  inheritAttrs: false
};
</script>

<style lang="scss" scoped>
.overlay {
  @apply bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40;
}
</style>
