<template>
  <view-dashboard-layout>
    <white-box>
      <div v-if="!loading">
        <white-box-heading class="p-6 flex flex-col md:flex-row items-center justify-between gap-6">
          <div class="flex-1 text-center md:text-left">
            <h3 class="text-xl font-medium mb-4 truncate max-w-[600px]">{{ project.title }}</h3>
            <div class="text-sm text-gray-600">
              <span v-if="contract.status == 2" class="flex items-center gap-2">
                <svg-vue icon="check-circle-solid" class="w-5 h-5 text-orange-600" />
                <span>Completed {{ (contract.completed_at) }}</span>
              </span>
              <span v-if="contract.status == 1">In-Process {{ contract.started_at }}</span>
            </div>
          </div>
          <button v-if="user.role === 'tasker'" :disabled="hasRequestCompleted" @click="sendRequestCompleted(project)" class="bg-blue-600 text-white text-md rounded-full px-6 py-2">
            Send Request Completed
          </button>
          <button v-if="user.role === 'poster' && contract.status != 2" :disabled="hasAcceptRequestCompleted" @click="acceptRequestCompleted(project)" class="bg-blue-600 text-white text-md rounded-full px-6 py-2">
            Accept Request Completed
          </button>
        </white-box-heading>
        <white-box-content class="px-6 py-8">
          <tab-wrapper :tabs="tabs" :selectedTab="selectedTab" @select-tab="selectTab" />

          <div class="tab-content">
            <!-- Review tab -->
            <div v-show="selectedTab === 'messages-files'">
              <messages-and-files :project="project" :student="contract.student" :owner="contract.owner" />
            </div>
            <div v-show="selectedTab === 'feedbacks'">
              <div class="rating-star flex items-center mb-2">
                <h4 class="font-semibold pr-3">Rating</h4>
                <star-rating :show-rating="false" :inline="true" :star-size="20" :star-points="[23,2, 14,17, 0,19, 10,34, 7,50, 23,43, 38,50, 36,34, 46,19, 31,17]" v-model="feedback.rating"></star-rating>
              </div>
              <div class="rating-comment">
                <h4 class="font-semibold mb-2">Comment</h4>
                <VueEditor v-model="feedback.comment" placeholder="Enter comment" />
              </div>
              <button @click="sendFeedBack(project, feedback)" class="bg-blue-600 text-white text-md rounded-full mt-2 px-6 py-2">Send</button>
            </div>
          </div>
        </white-box-content>
      </div>
      <div v-else>
        <p class="text-center py-20">Loading</p>
      </div>
    </white-box>
  </view-dashboard-layout>
</template>

<script>
import WhiteBox from '../../components/shared/WhiteBox.vue';
import WhiteBoxContent from '../../components/shared/WhiteBoxContent.vue';
import WhiteBoxHeading from '../../components/shared/WhiteBoxHeading.vue';
import ViewDashboardLayout from '../ViewDashboardLayout.vue';
import TabWrapper from '../../components/shared/TabWrapper.vue';
import MessagesAndFiles from './MessagesAndFiles.vue';
import { VueEditor } from 'vue2-editor';
import StarRating from 'vue-star-rating'

export default {
  components: { ViewDashboardLayout, WhiteBox, WhiteBoxHeading, WhiteBoxContent, TabWrapper, MessagesAndFiles, StarRating, VueEditor },
  data() {
    return {
      loading: false,
      contract: {},
      feedback: {
        rating: 0,
        comment: ''
      },
      selectedTab: 'messages-files',
      tabs: {
        'messages-files': { name: 'Messages & Files', target: 'messages-files' },
        feedbacks: { name: 'Feedbacks', target: 'feedbacks' }
      },
      hasRequestCompleted: false,
      hasAcceptRequestCompleted: false
    };
  },
  computed: {
    project() {
      return typeof this.contract.project == 'object' ? this.contract.project : {}
    },
    user() {
      return this.$util.options.auth || {};
    }
  },
  props: {
    contractId: Number
  },
  methods: {
    selectTab(tab) {
      this.selectedTab = tab;
    },
    getContract() {
      this.loading = true;
      this.$util.get(`contracts/${this.contractId}`).then((res) => {
        this.contract = res;
        this.feedback = Object.assign(this.feedback, res.feedback);
        this.loading = false;
      });
    },
    async sendRequestCompleted(project) {
      let loader = this.$loading.show({
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel
      });

      try {
        await this.$util.post(`projects/request-completed`, { project_id: project.id });
        this.hasRequestCompleted = true;
        Toast.fire('Your request was sent', '', 'success');
      } catch (error) {
        if (error.response) {
          Toast.fire('Something went wrong. Please try again', '', 'error');
        }
      } finally {
        loader.hide();
      }
    },
    async acceptRequestCompleted(project) {
      let loader = this.$loading.show({
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel
      });

      try {
        await this.$util.post(`projects/confirmation-completed`, { project_id: project.id });
        this.hasAcceptRequestCompleted = true;
        Toast.fire('Successful confirmation', '', 'success');
      } catch (error) {
        if (error.response) {
          Toast.fire('Something went wrong. Please try again', '', 'error');
        }
      } finally {
        loader.hide();
      }
    },
    async sendFeedBack(project, feedback) {
      let loader = this.$loading.show({
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel
      });
      try {
        await this.$util.post(`contracts/feedback/${this.contractId}`, feedback).then(response => {
          Toast.fire(response.message, '', 'success');
        }).catch(error => {
          Toast.fire(error.message, '', 'error');
        });
      } catch (error) {
        Toast.fire('Something went wrong. Please try again', '', 'error');
      } finally {
        loader.hide();
      }
    }
  },
  created() {
    this.getContract();
    if (this.user.role != 'poster') {
      delete this.tabs.feedbacks
    }
    const hash = window.location.hash.substring(1);
    this.selectedTab = hash && this.selectedTab !== '' ? hash : 'messages-files';
  }
};
</script>

<style></style>
