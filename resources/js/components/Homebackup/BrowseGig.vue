<template>
  <div class="browse-gig">
    <div class="container py-10">
      <div class="rounded-md text-white">
        <div class="max-w-md md:pt-40">
          <h2 class="text-5xl font-extrabold mb-6">Browse gigs</h2>
          <p class="text-xl mb-4">
            Get ready to thrive in the gig economy by volunteering up to 50 hours of your talents on mini projects or "gigs" that benefit the CDU
            community
          </p>
          <p class="text-xl">
            Many gigs are online, so you can work on them whenever and wherever it suits you. We're looking for people with skills in the following:
          </p>
        </div>

        <div class="category-wrapper">
          <div v-for="(category, i) in categories" :key="i" class="category-box">
            <span class="category-box__name">{{ category.name }}</span>
            <ul>
              <li v-for="(sub, index) in category.subs" :key="index">
                <a :href="`/browse-gig/${sub.slug}`">
                  <span>{{ sub.name }}</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                  </svg>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    categories: {
      type: Array,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
.browse-gig {
  background: url(/images/find-talent.webp) center center no-repeat;
  background-size: cover;
}
.category-wrapper {
  @apply grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-8;
}
.category-box {
  @apply flex flex-col bg-red-400/50 rounded-md p-4;

  &__name {
    @apply text-2xl font-bold mb-2;
  }

  ul {
    li {
      @apply py-1;
      a {
        @apply flex items-center gap-2 transition duration-300;
        &:hover {
          @apply text-gray-400;
        }
      }
    }
  }
}
</style>
