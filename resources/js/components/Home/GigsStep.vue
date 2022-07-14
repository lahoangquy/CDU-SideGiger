<script>
export default {
  props: {
    steps: {
      type: Array,
      required: true
    }
  }
};
</script>

<template>
  <div class="gigs-steps">
    <a v-for="step in steps" :key="step.id" class="gigs-step">
      <div class="icon-wrapper">
        <div class="icon">
          <component :is="step.icon"></component>
        </div>
      </div>
      <div class="title">
        {{ step.text }}
      </div>
    </a>
  </div>
</template>

<style lang="scss" scoped>
.gigs-steps {
  background-color: var(--base-white);
  padding: 16px;
  width: 100%;
  display: flex;
  justify-content: space-between;
  margin-bottom: 16px;
  column-gap: 16px;
  flex-grow: 1;
  height: 100%;
  .gigs-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    text-decoration: none !important;
    color: currentColor !important;
    .icon-wrapper {
      border-radius: 50%;
      width: 60px;
      height: 60px;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: var(--light-gray);
      .icon {
        border-radius: 50%;
        width: 30px;
        height: 30px;
        color: var(--gray);
      }
    }
    .title {
      padding-top: 8px;
      text-align: center;
      font-size: 10px;
    }
  }
}
</style>
