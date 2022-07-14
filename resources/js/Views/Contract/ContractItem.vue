<template>
  <div class="p-6 hover:bg-gray-50 transition duration-300">
    <a class="text-lg font-medium inline-block mb-4 hover:text-red-500 hover:underline" :href="`/dashboard/contract/${contract.id}`">{{
      contract.project.title
    }}</a>
    <div class="flex justify-between items-center text-gray-700">
      <span v-if="user.role === 'poster'">Hired: {{ contract.student.name }}</span>
      <span v-else>Hired By: {{ contract.owner.name }}</span>
      <div v-if="contract.status == 1">In-Process</div>
      <div v-else class="items-center gap-3">
        <p>Completed</p>
        <p>
          <star-rating v-show="Math.ceil(feedback.rating) > 0" :rating="feedback.rating" :read-only="true" :show-rating="false" :inline="true" :star-size="20" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]"></star-rating>
        </p>
      </div>
      <div>
        <span v-if="contract.status == 1">{{ contract.started_at }}</span>
        <span v-else>{{ contract.started_at }} - {{ contract.completed_at }}</span>
      </div>
    </div>
  </div>
</template>

<script>

import StarRating from 'vue-star-rating'
export default {
  components: { StarRating },
  props: {
    contract: {
      type: Object,
      default: () => { }
    }
  },
  computed: {
    user() {
      return this.$util.options.auth || {};
    },
    feedback() {
      return this.contract.feedback != undefined ? this.contract.feedback : {}
    }
  }
};
</script>

<style></style>
