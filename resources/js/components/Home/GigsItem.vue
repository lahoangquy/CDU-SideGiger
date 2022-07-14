<script>
export default {
  props: {
    isStaff: {
      type: Boolean,
      required: false
    },
    title: {
      type: String,
      required: true
    }
  }
};
</script>

<template>
  <div v-bind:class="['gigs', { 'is-staff': isStaff }]">
    <h2 class="title">{{ title }}</h2>
    <slot></slot>
  </div>
</template>

<style lang="scss" scoped>
.gigs {
  padding-left: 128px;
  padding-right: 64px;
  padding-top: 16px;
  padding-bottom: 24px;
  color: var(--base-black);
  background: var(--pearl);
  display: flex;
  flex-direction: column;
  &.is-staff {
    background: var(--yellow);
  }

  .title {
    text-transform: uppercase;
    font-weight: 800;
    font-size: 32px;
  }
}
</style>
