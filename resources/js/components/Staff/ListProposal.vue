<template>
  <div>
    <div v-if="filterOffers.length" class="divide-y divide-dotted">
      <div v-for="(offer, i) in filterOffers" :key="i" class="proposal-item">
        <div class="grow">
          <div class="text-md font-normal text-gray-500 mb-2">
            <a href="#" content="View profile this student" v-tippy="{ arrow: true }" class="font-semibold hover:text-blue-500 hover:underline">{{
              offer.user.name
            }}</a>
            submitted on
            {{ new Date(offer.created_at).toDateString('AU') }}
            <BaseToolTip :toolTipId="`tooltip-${i}`" content="View profile this student" />
          </div>
          <div class="text-sm" v-html="offer.comment"></div>
        </div>
        <div class="flex items-center gap-2">
          <button @click="acceptProposal(offer)" class="bg-blue-400 rounded-full text-xs text-white py-1 px-2">Accept</button>
          <button @click="declineProposal(offer)" class="bg-white hover:bg-gray-50 border border-gray-100 rounded-full text-xs py-1 px-2">
            Decline
          </button>
        </div>
      </div>
    </div>
    <div v-else>
      <p class="proposal-item text-red-600">There is no applicates yet</p>
    </div>
  </div>
</template>

<script>
import BaseToolTip from '../BaseToolTip.vue';
import { mapGetters, mapActions } from 'vuex';
export default {
  components: { BaseToolTip },
  props: ['project'],
  computed: {
    filterOffers() {
      return this.project.offers.filter((offer) => offer.status != 2);
    },
    user() {
      return this.$util.options.auth || {};
    },
  },
  methods: {
    ...mapActions({
      getStaffProject: 'project/getProjectByOwner'
    }),
    acceptProposal(offer) {
      console.log('decine')
      this.$util
        .post(`applicates/accept/${offer.id}`, offer)
        .then((response) => {
          console.log(response)
          this.getStaffProject(this.user.id);
          this.$swal('Congratulation', 'You now be started on your contract with this student', 'success');
          this.$emit('close');
        })
        .catch((error) => {
          console.log(error)
          this.$swal('Oop..', error, 'error');
        });
    },
    declineProposal(offer) {
      this.$util
        .post(`applicates/decine/${offer.id}`, offer)
        .then((response) => {
          Toast.fire('The applicate was decined', '', 'success');
          this.$emit('close');
        })
        .catch((error) => {
          if (error.response) {
            console.log(error.response);
            this.$swal('Oop..', error.message, 'error');
          }
        });
    }
  }
};
</script>

<style lang="scss">
.base-modal__content {
  padding: 0 0 1.5rem 0 !important;
}
.proposal-item {
  @apply flex items-start justify-between gap-4 p-6 hover:bg-gray-50 transition duration-300;
}
</style>
