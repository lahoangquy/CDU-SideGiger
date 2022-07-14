<script>
export default {
  props: {
    isStaff: {
      type: Boolean,
      required: false
    },
    href: {
      type: String,
      default: '#'
    }
  }
};
</script>

<template>
  <div v-bind:class="['gigs-btn', { 'is-staff': isStaff }]">
    <a class="wrapper" :href="href">
      <slot></slot>
    </a>
  </div>
</template>

<style lang="scss" scoped>
.gigs-btn {
  color: var(--base-white);
  background: var(--yellow);
  border: 40px;
  padding: 10px;
  border-radius: 40px;
  width: 200px;
  &.is-staff {
  background: var(--pearl);
  }

  .wrapper {
    font-weight: bold;
    font-size: 20px;
    border: 3px solid var(--base-white);
    border-radius: 40px;
    background: transparent;
    padding: 5px 20px;
    width: 100%;
    display: block;
    text-align: center;
  }
}
</style>
