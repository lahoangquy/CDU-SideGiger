<template>
  <div class="container px-4 my-8 md:max-w-5xl pb-20">
    <h1 class="text-4xl font-semibold mb-8">Submit a proposal</h1>

    <form class="p-0 shadow-none">
      <div class="rounded-md border border-gray-200 shadow-md">
        <div class="p-6 border-b border-gray-200">
          <h2 class="text-2xl font-medium">Task Detail</h2>
        </div>
        <div class="p-6">
          <h3 class="text-xl font-medium">{{ project.title }}</h3>
          <task-post-info :project="project" class="mt-4 mb-8" />
          <div v-html="project.description" class="text-sm"></div>
          <task-attachment :project="project" />
        </div>
      </div>

      <div class="rounded-md border border-gray-200 mt-8 shadow-md">
        <div class="p-6 border-b border-gray-200">
          <h2 class="text-2xl font-medium">Additonal Info For Your Proposal</h2>
        </div>
        <div class="p-6">
          <div class="form-group">
            <label for="">Cover Letter</label>
            <textarea v-model="offer.comment" class="form-control min-h-[150px]"></textarea>
            <span v-if="$v.offer.comment.$error" class="text-sm text-red-400 font-light"> This field is required </span>
          </div>

          <div class="flex items-center gap-4 mt-8">
            <button @click.prevent="submitProposal" :disabled="loading" class="btn btn-primary max-w-[200px]">
              {{ loading ? 'Processing...' : 'Submit a Proposal' }}
            </button>
            <a href="/tasks">Cancel</a>
          </div>
        </div>
      </div>
    </form>

    <confirm-modal icon="check-circle-solid" :show="showPopConfirm" :showCloseButton="false" actionText="I understand" @handle-confirm="handleConfirm" @close="showPopConfirm = false">
      Your offer was subbmitted. Poster who is owner of this task will response your request early!
    </confirm-modal>
  </div>
</template>

<script>
import TaskAttachment from '../TaskAttachment.vue';
import TaskPostInfo from '../TaskPostInfo.vue';
import { required } from 'vuelidate/lib/validators';
import ConfirmModal from '../../ConfirmModal.vue';
import { mapGetters, mapActions } from 'vuex';

export default {
  components: { TaskPostInfo, TaskAttachment, ConfirmModal },
  props: {
    projectId: {
      type: Number,
      required: true
    }
  },
  data: () => {
    return {
      showPopConfirm: false,
      loading: false,
      error: '',
      offer: {
        user_id: '',
        project_id: '',
        comment: ''
      }
    };
  },
  computed: {
    ...mapGetters({
      project: 'project/project'
    }),
    user() {
      return this.$util.options.auth;
    }
  },
  validations: {
    offer: {
      comment: {
        required
      }
    }
  },
  methods: {
    ...mapActions({
      getAllCategories: 'category/getAllCategories',
      getStaffProject: 'project/getProjectByOwner',
      getProject: 'project/getProject'
    }),
    async fetchProject() {
      await this.getProject(this.projectId);

      this.offer.user_id = this.user.id;
      this.offer.project_id = this.projectId;
    },
    submitProposal() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.loading = true;
        this.$util
          .post(`projects/storeOffer`, this.offer)
          .then((res) => {
            this.showPopConfirm = !this.showPopConfirm;
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => (this.loading = false));
      }
    },
    handleConfirm() {
      window.location.href = '/tasks';
    }
  },
  created() {
    this.fetchProject();
  }
};
</script>

<style></style>
