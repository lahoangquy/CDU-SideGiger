<template>
  <div class="flex flex-col space-y-0 mt-1.5">
    <div class="flex items-center space-x-0">
      <span v-for="(star, i) in Array(stars)" :key="i">
        <svg-vue icon="star" class="w-5 h-5 text-orange-500" />
      </span>
    </div>
    <div class="text-sm">4.9 of 35 reviews</div>
  </div>
</template>

<script>
export default {
  name: 'Rating',

  props: {
    stars: {
      type: String | Number,
      default: 5
    }
  }
};
</script>
