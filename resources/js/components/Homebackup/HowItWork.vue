<template>
  <div class="how-it-work">
    <div class="container py-20 px-4 md:max-w-[850px]">
      <h2 class="text-4xl font-bold mb-14 text-center">How it works</h2>
      <div class="how-it-work__icons">
        <div v-for="(item, i) in howItWorks" :key="i" class="icon-box">
          <div class="icon">
            <svg-vue :icon="item.icon" class="opacity-50" />
          </div>
          <p class="text-gray-600 text-md leading-6">
            {{ item.text }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data: () => {
    return {
      howItWorks: [
        {
          icon: 'user-circle',
          text: 'Create your profile'
        },
        {
          icon: 'search',
          text: 'Browse and apply for gigs'
        },
        {
          icon: 'open-email',
          text: 'You will be notified if you win the gig'
        },
        {
          icon: 'user-circle',
          text: 'Understand project requirements'
        },
        {
          icon: 'user-circle',
          text: 'Complete and submit work'
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.how-it-work {
  @apply bg-gray-50 flex flex-col items-center;

  &__icons {
    @apply flex flex-col md:flex-row justify-between space-x-6 space-y-4 md:space-y-0;

    .icon-box {
      @apply flex flex-col justify-center items-center space-y-4 text-center;

      .icon {
        @apply bg-gray-100 flex justify-center items-center p-4 w-[80px] h-[80px] rounded-full;
      }
    }
  }
}
</style>
