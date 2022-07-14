<template>
  <view-dashboard-layout>
    <h1 class="dashboard__heading">List Proposal Pending</h1>

    <white-box>
      <white-box-content>
        <div v-if="proposals.length" class="flex flex-col">
          <div class="sm:-mx-6 lg:-mx-8">
            <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
              <table class="min-w-full">
                <thead class="bg-gray-100 dark:bg-gray-700">
                  <tr>
                    <th scope="col" width="450">Project Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Submitted</th>
                    <th scope="col" class="relative py-3 px-6">
                      <span class="sr-only">Action</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(proposal, i) in proposals" :key="i">
                    <td>{{ proposal.project.title }}</td>
                    <td>{{ proposal.project.category.name }}</td>
                    <td>{{ proposal.created_at }}</td>
                    <td>
                      <button @click.prevent="withdraw(proposal)" class="rounded-lg text-sm bg-blue-400 text-white px-2 py-1 border border-gray-200">
                        Withdraw proposal
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div v-else class="py-6 text-center">There was no proposal yet.</div>
      </white-box-content>
    </white-box>
  </view-dashboard-layout>
</template>

<script>
import WhiteBox from '../components/shared/WhiteBox.vue';
import WhiteBoxContent from '../components/shared/WhiteBoxContent.vue';
import ViewDashboardLayout from '../Views/ViewDashboardLayout.vue';

export default {
  components: { ViewDashboardLayout, WhiteBox, WhiteBoxContent },
  data() {
    return {
      proposals: []
    };
  },
  computed: {
    user() {
      return this.$util.options.auth || {};
    },
  },
  methods: {
    async getProposals() {
      this.proposals = await this.$util.get(`user/applicates/${this.user.id}`);
    },
    withdraw(proposal) { }
  },
  created() {
    this.getProposals();
  }
};
</script>

<style></style>
