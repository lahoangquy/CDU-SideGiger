<template>
  <view-dashboard-layout>
    <h1 class="dashboard__heading">All Contracts</h1>
    <white-box>
      <white-box-heading class="flex justify-between px-6 py-4">
        <div class="flex gap-3">
          <select v-model="selectedStatus" class="select-input">
            <option value="">All statuses</option>
            <option v-for="(status, i) in contractStatues" :key="i" :value="status.id">
              {{ status.name }}
            </option>
          </select>
        </div>
        <!-- <button class="flex-none text-right flex gap-1 items-center">
          <svg-vue icon="download" class="w-5 h-5" />
          <span>Download CSV</span>
        </button> -->
      </white-box-heading>
      <white-box-content>
        <div class="divide-y divide-gray-200">
          <contract-item v-for="contract in filterContracts" :key="contract.id" :contract="contract" />
        </div>
      </white-box-content>
    </white-box>
  </view-dashboard-layout>
</template>

<script>
import WhiteBox from '../../components/shared/WhiteBox.vue';
import WhiteBoxContent from '../../components/shared/WhiteBoxContent.vue';
import WhiteBoxHeading from '../../components/shared/WhiteBoxHeading.vue';
import ViewDashboardLayout from '../ViewDashboardLayout.vue';
import ContractItem from './ContractItem.vue';
import { mapGetters, mapActions } from 'vuex';

export default {
  components: { ViewDashboardLayout, WhiteBox, WhiteBoxHeading, WhiteBoxContent, ContractItem },
  data() {
    return {
      contracts: [],
      selectedStatus: ''
    };
  },
  computed: {
    ...mapGetters({
      contractStatues: 'contract/statuses'
    }),
    filterContracts() {
      if (this.selectedStatus) {
        return this.contracts.filter((contract) => contract.status == this.selectedStatus);
      }
      return this.contracts;
    }
  },
  methods: {
    async getContracts() {
      this.contracts = await this.$util.get(`contracts`);
    }
  },
  created() {
    this.getContracts();
  }
};
</script>

<style></style>
