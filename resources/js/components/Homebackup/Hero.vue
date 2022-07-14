<template>
  <div class="relative hero">
    <div class="hero__overlay"></div>
    <div class="container">
      <div class="flex flex-col max-w-3xl">
        <h1>CDU Student SideGigger</h1>
        <p class="text-white font-normal text-3xl">Do you want to:</p>
        <ul class="mt-4">
          <li>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
            <span>Hone your skills?</span>
          </li>
          <li>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
            <span>Boost your confidence?</span>
          </li>
          <li>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
            <span>Increase your employability?</span>
          </li>
        </ul>

        <div class="hero__button-wrapper">
          <a href="/register">Become a CDU Student</a>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.hero {
  background: url('./images/undraw_pair_programming_re_or4x.svg') no-repeat right center;
  background-size: 30%;

  &__overlay {
    @apply bg-red-400 bg-opacity-75 absolute top-0 left-0 w-full h-full z-0;
  }

  .container {
    @apply flex justify-between items-center py-28 px-4 relative z-10;

    h1 {
      @apply text-white font-bold text-4xl md:text-6xl mb-6;
    }

    ul {
      li {
        @apply flex items-center gap-1 text-white font-medium text-lg;
      }
    }
  }

  &__button-wrapper {
    @apply flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mt-10;

    a {
      @apply bg-red-500 hover:bg-red-600 shadow rounded-full px-8 py-4 text-white font-bold transition duration-300 text-center w-full md:w-auto;
    }
  }
}
</style>
