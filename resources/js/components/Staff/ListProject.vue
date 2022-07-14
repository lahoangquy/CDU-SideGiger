<template>
  <div>
    <div class="flex flex-col md:flex-row items-center mb-6 gap-4">
      <div class="flex gap-4 flex-1">
        <select v-model="selectedStatus" class="select-control max-w-[180px]">
          <option value="">All statuses</option>
          <option v-for="(status, i) in projectStatues" :key="i" :value="status.id">
            {{ status.name }}
          </option>
        </select>
        <select v-model="selectedCategory" class="select-control max-w-[180px]">
          <option value="">All Category</option>
          <optgroup v-for="(cate, i) in categories" :key="i" :label="cate.name">
            <option v-for="(c, k) in cate.subs" :key="k" :value="c.id">
              {{ c.name }}
            </option>
          </optgroup>
        </select>
      </div>
      <button @click="toogleProjectModal('')" class="btn btn-primary max-w-[180px] flex items-center gap-2">
        <svg-vue icon="plus-circle" class="w-5 h-5" />
        <span>Create new gig</span>
      </button>
    </div>
    <div class="flex flex-col">
      <div class="sm:-mx-6 lg:-mx-8">
        <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
          <div class="shadow-md sm:rounded-lg">
            <table class="min-w-full">
              <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                  <th scope="col" width="450">Name</th>
                  <th scope="col">Category</th>
                  <th scope="col">Status</th>
                  <th scope="col">Due Date</th>
                  <th scope="col" class="relative py-3 px-6">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(project, i) in filterProjects" :key="i">
                  <td>{{ project.title }}</td>
                  <td>{{ project.category.name }}</td>
                  <td>{{ project.statusText }}</td>
                  <td v-html="$util.timestampToDate(project.due_date)"></td>
                  <td class="text-right whitespace-nowrap">
                    <div class="relative">
                      <button v-if="project.status == 1" @click="selectDropMenu(project.id)" class="rounded-full border border-gray-200 hover:bg-gray-100 py-1 w-[28px] h-[28px] flex items-center justify-center">
                        <svg-vue icon="dot-horizontal" class="h-4 w-4" />
                      </button>
                      <div class="my-dropdown absolute top-8 right-0 z-50" :class="activeDropdown !== project.id ? 'hidden' : ''">
                        <ul class="py-1" v-if="project.status == 1">
                          <li><a href="#" @click.prevent="openInviteModal(project)">Invite</a></li>
                          <li><a href="#" @click.prevent="openListProposal(project)">List Applicates</a></li>
                          <li><a href="#" @click.prevent="toogleProjectModal(project.id)">Edit</a></li>
                          <li><a href="#" @click.prevent="deleteProject(project.id)">Delete</a></li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <BaseModal :show="showAddProjectModal" @close="showAddProjectModal = !showAddProjectModal" size="3xl" :title="projectId != '' ? 'Edit Task' : 'Create New Task'">
      <CreateProjectForm @close="showAddProjectModal = !showAddProjectModal" :projectId="projectId" />
    </BaseModal>

    <BaseModal :show="showListProposalModal" @close="closeProposalModal" size="3xl" title="List Of Applicates">
      <ListProposal :project="selectedProject" @close="closeProposalModal" />
    </BaseModal>

    <BaseModal :show="showInviteModal" @close="closeInviteModal" title="Invite a Student">
      <list-student-to-invite :students="students" :project="projectBeInvited" @close="closeInviteModal" />
    </BaseModal>
  </div>
</template>

<script>
import BaseModal from '../BaseModal.vue';
import CreateProjectForm from './CreateProjectForm.vue';
import { mapGetters, mapActions } from 'vuex';
import ListProposal from './ListProposal.vue';
import ListStudentToInvite from './ListStudentToInvite.vue';

export default {
  components: { BaseModal, CreateProjectForm, ListProposal, ListStudentToInvite },
  data: () => {
    return {
      createNewProjectModalId: 'add-project-modal',
      showAddProjectModal: false,
      showListProposalModal: false,
      showInviteModal: false,
      selectedProject: '',
      selectedStatus: '',
      selectedCategory: '',
      activeDropdown: '',
      students: [],
      projectBeInvited: '',
      projectId: ''
    };
  },
  computed: {
    ...mapGetters({
      projects: 'project/projects',
      categories: 'category/categories',
      projectStatues: 'project/statuses'
    }),
    user() {
      return this.$util.options.auth || {};
    },
    filterProjects() {
      let result = this.projects;
      if (this.selectedStatus) {
        result = result.filter((project) => Number(project.status) === this.selectedStatus);
      }

      if (this.selectedCategory) {
        result = result.filter((project) => project.category.id === this.selectedCategory);
      }

      return result;
    }
  },
  methods: {
    ...mapActions({
      getAllCategories: 'category/getAllCategories',
      getStaffProject: 'project/getProjectByOwner'
    }),
    deleteProject(projectId) {
      this.activeDropdown = '';
      this.$swal({
        title: 'Are you sure?',
        text: 'Are you still want to delete this project?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then(async (result) => {
        if (result.isConfirmed) {
          const data = await this.$util.post(`projects/delete/${projectId}`);
          Toast.fire(data.message, '', 'success');
          this.getStaffProject(this.user.id);
        }
      });
    },
    toogleProjectModal(projectId) {
      this.projectId = projectId;
      this.showAddProjectModal = !this.showAddProjectModal
      this.activeDropdown = '';
    },
    /* openAddProjectModal(modal) {
      this.activeDropdown = '';
      toggleModal(modal, true);
    }, */
    openListProposal(project) {
      this.activeDropdown = '';
      this.selectedProject = project;
      this.showListProposalModal = true;
    },
    closeProposalModal() {
      this.showListProposalModal = !this.showListProposalModal;
      this.selectedProject = '';
    },
    selectDropMenu(pid) {
      this.activeDropdown ? (this.activeDropdown = '') : (this.activeDropdown = pid);
    },
    async getStudents() {
      this.students = await this.$util.get(`user/only-student`);
    },
    openInviteModal(project) {
      this.getStudents();
      this.projectBeInvited = project;
      this.showInviteModal = true;
      this.activeDropdown = '';
    },
    closeInviteModal() {
      this.showInviteModal = false;
      this.students = [];
      this.activeDropdown = '';
    }
  },
  created() {
    this.getStaffProject(this.user.id);
    this.getAllCategories();

    // if this URL is comming from email
    // check its hash string and open current modal
    const projectHash = window.location.hash.substring(1);
    const projectId = !isNaN(parseInt(projectHash)) ? parseInt(projectHash) : null;
    if (projectId) {
      this.$util.get(`projects/${projectId}`).then((response) => {
        this.openListProposal(response);
      });
    }
  }
};
</script>

<style lang="scss">
table {
  th {
    @apply py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400;
  }

  tbody {
    tr {
      @apply border-b odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700 dark:border-gray-600;

      td {
        @apply py-4 px-6 text-sm font-medium text-gray-900 whitespace-normal dark:text-white;

        a {
          @apply text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:underline;
        }
      }
    }
  }

  .my-dropdown {
    @apply z-[999] w-44 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700;

    li {
      a {
        @apply flex items-center gap-2 py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white;
      }
    }
  }
}
</style>
