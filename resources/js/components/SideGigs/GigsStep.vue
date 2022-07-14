<script>
export default {
  props: {
    steps: {
      type: Array,
      required: true
    }
  },
};
</script>

<template>
  <div class="gigs-steps">
    <div v-for="(step, i) in steps" :key="i" class="gigs-step" >
      <a :href="`/browse-gig/`">
        <div class="wrapper">
          <div class="icon-wrapper">
            <div div class="icon">
             <svg-vue :icon="step.icon" class="opacity-50" />
          </div>
          </div>
          <div class="title">
            {{ step.label }}
          </div>
        </div>
      </a>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.gigs-steps {
  background-color: var(--base-white);
  padding: 32px;
  width: 100%;
  display: flex;
  justify-content: space-between;
  .gigs-step {
    display: flex;
    flex-direction: column;
    height: 100%;
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
    }
  }
}
</style>
