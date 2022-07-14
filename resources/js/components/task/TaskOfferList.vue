<template>
  <div class="flex">
    <div class="border-b border-gray-200 p-6">
      <h3 class="text-2xl font-normal mb-12">Offers</h3>

      <div class="flex flex-col mt-6" v-for="(arr, i) in Array(3)" :key="i">
        <div class="flex space-x-4">
          <div class="flex-none rounded-full w-12 h-12 bg-gray-200">&nbsp;</div>
          <div>
            <a href="/preview-profile/1">John Doe</a>
            <Rating />
          </div>
        </div>
        <div class="mt-6 bg-gray-50 p-4 text-gray-500 text-sm rounded">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate
            dolores fugiat ipsum
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate
            dolores fugiat ipsum
          </p>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate
            dolores fugiat ipsum
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Rating from '../Rating.vue';
export default {
  components: { Rating }
};
</script>
