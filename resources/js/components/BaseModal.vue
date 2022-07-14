<template>
  <Overlay v-if="show">
    <div aria-hidden="true" class="base-modal">
      <div :class="`relative px-4 w-full h-full md:h-auto max-w-${size}`">
        <div class="base-modal__body">
          <!-- Modal heading -->
          <div v-if="title" class="base-modal__heading">
            <h3>{{ title }}</h3>
            <button type="button" class="btn-close" @click.stop.prevent="$emit('close')">
              <svg-vue icon="close" class="w-5 h-5" />
            </button>
          </div>

          <!-- Modal content -->
          <div class="base-modal__content" style="max-height: calc(100vh - 100px)">
            <slot />
          </div>
        </div>
      </div>
    </div>
  </Overlay>
</template>

<script>
import Overlay from './Overlay.vue';
export default {
  components: { Overlay },
  props: {
    show: {
      type: Boolean,
      default: false
    },
    size: {
      type: String,
      default: 'md'
    },
    modalId: {
      type: String,
      default: 'defaultModal'
    },
    title: {
      type: String,
      default: 'Modal Title'
    }
  }
};
</script>

<style lang="scss" scoped>
.base-modal {
  @apply overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 flex justify-center items-center h-modal md:h-full md:inset-0;

  &__body {
    @apply relative bg-white rounded-lg shadow dark:bg-gray-700;
  }

  &__heading {
    @apply flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600;

    h3 {
      @apply text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white;
    }
  }

  .btn {
    &-cancel {
      @apply text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600;
    }
    &-close {
      @apply text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white;
    }
  }

  &__content {
    @apply p-6 space-y-6 h-auto overflow-y-auto;
  }
}
</style>
