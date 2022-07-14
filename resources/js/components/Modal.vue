<template>
  <div v-if="show" @click="$emit('close')" class="overlay">
    <div @click.stop :class="`md:max-w-${layoutSize}`" class="modal">
      <h3>{{ title }}</h3>
      <div class="px-4">
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: {
      required: true,
      type: Boolean
    },
    layoutSize: {
      type: String,
      default() {
        return 'md';
      }
    },
    title: {
      type: String,
      default: 'Title Modal'
    }
  },
  mounted() {
    document.addEventListener('keydown', (e) => {
      if (this.show && e.keyCode == 27) {
        this.$emit('close');
      }
    });
  }
};
</script>

<style lang="scss" scoped>
.overlay {
  @apply z-50 fixed w-screen h-screen bg-gray-900 bg-opacity-50 top-0 right-0 flex justify-center items-center p-6;
}

.modal {
  @apply bg-white p-6 w-full rounded-md shadow-md;

  h3 {
    @apply text-2xl font-medium mb-14 text-center;
  }
}
</style>
