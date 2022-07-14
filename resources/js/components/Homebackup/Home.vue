<template>
  <div>
    
  </div>
</template>

<script>
import BrowseGig from './BrowseGig.vue';
import Hero from './Hero.vue';
import HowItWork from './HowItWork.vue';
import WhyBusiness from './WhyBusiness.vue';

export default {
  components: { Hero, HowItWork, BrowseGig, WhyBusiness },
  data() {
    return {
      categories: []
    };
  },
  computed: {
    user() {
      return this.$util.options.auth || {};
    }
  },
  methods: {
    async fetchAllCategories() {
      this.categories = await this.$util.get(`categories`);
    }
  },
  created() {
    this.fetchAllCategories();
  }
};
</script>
