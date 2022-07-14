<template>
  <div class="how-it-work">
    <div class="container py-20 px-4">
      <h2 class="text-4xl font-bold mb-6 text-center">CDU SideGigger for Staff</h2>
      <div class="text-center text-lg">
        <p>Need resource to complete a project that will benefit the CDU community?</p>
        <p>Our talented students are looking for experience.</p>
        <p>Post a mini project or "gig" of no more than 50 hours and let a student volunteer to help you get things done!</p>

        <div class="mt-10 mb-14">
          <a :href="`${isLoggedAsPoster ? '/staff/manage-project' : '/register'}`" class="btn-cta">Post a gig</a>
        </div>
      </div>

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
import { mapGetters } from 'vuex';
export default {
  data: () => {
    return {
      howItWorks: [
        {
          icon: 'user-circle',
          text: 'Identify a discrete task  requiring no more than 50 hours work*'
        },
        {
          icon: 'search',
          text: 'Ensure you have clear outcomes and expectations '
        },
        {
          icon: 'open-email',
          text: 'Post your gig'
        },
        {
          icon: 'user-circle',
          text: 'Review applications and select  student '
        },
        {
          icon: 'user-circle',
          text: 'Cleary communicate expectations and negotiate requirements'
        },
        {
          icon: 'user-circle',
          text: 'Support student to complete the task'
        }
      ]
    };
  },
  props: {
    user: [Object]
  },
  computed: {
    isLoggedAsPoster() {
      return this.user && this.user.role === 'poster';
    }
  }
};
</script>

<style lang="scss" scoped>
.how-it-work {
  @apply bg-gray-50 flex flex-col items-center;

  &__icons {
    @apply grid grid-cols-2 md:grid-cols-6 justify-between space-x-6 space-y-4 md:space-y-0;

    .icon-box {
      @apply flex flex-col justify-start items-center space-y-4 text-center;

      .icon {
        @apply bg-gray-100 flex justify-center items-center p-4 w-[80px] h-[80px] rounded-full;
      }
    }
  }

  .btn-cta {
    @apply bg-red-500 hover:bg-red-600 shadow rounded-full px-12 py-4 text-white font-bold transition duration-300;
  }
}
</style>
