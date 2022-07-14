<template>
  <div class="list-gig bg-gray-100">
    <div class="container px-4">
      <div class="w-full col-span-2">
        <div class="list-gig__content">
          <div class="p-6 border-b border-gray-200">
            <h1 class="text-3xl mb-8">Gigs you might like</h1>
            <div class="grid grid-cols-4 gap-4">
              <select v-model="selectedStatus" class="select-input">
                <option value="">All statuses</option>
                <option v-for="(status, i) in projectStatues" :key="i" :value="status.id">
                  {{ status.name }}
                </option>
              </select>
              <select v-model="selectedCategory" class="select-input">
                <option value="">All Category</option>
                <optgroup v-for="(category, i) in categories" :key="i" :label="category.name">
                  <option v-for="(sub, index) in category.subs" :key="index" :value="sub.id">
                    {{ sub.name }}
                  </option>
                </optgroup>
              </select>
            </div>
          </div>

          <div class="flex flex-col">
            <TaskItem v-for="project in filterProjects" :key="project.id" :project="project" @open-task="openTask(project)" />
          </div>
        </div>
      </div>
      <div class="w-full">
        <div class="p-4 bg-white border border-gray-200 rounded-md flex flex-col justify-center items-center space-y-4">
          <span class="inline-block w-14 h-14 bg-gray-200 rounded-full"></span>
          <p class="font-bold">John Doe</p>
          <p class="text-center">PHP, Laravel, VueJS, ReactJS, HubSpot CRM, Front-end</p>
        </div>
      </div>
    </div>

    <TaskDetail @updateTaskModal="closeTaskModal($event)" :open="open" :project="selectedProject" :user="user"></TaskDetail>
  </div>
</template>

<script>
import TaskItem from './TaskItem.vue';
import { mapGetters, mapActions } from 'vuex';
import TaskDetail from './Detail.vue';

export default {
  components: { TaskItem, TaskDetail },
  name: 'List',
  data() {
    return {
      open: false,
      selectedProject: null,
      selectedCategory: '',
      selectedStatus: ''
    };
  },
  computed: {
    ...mapGetters({
      categories: 'category/categories',
      projects: 'project/projects',
      projectStatues: 'project/statuses'
    }),
    user() {
      return this.$util.options.auth || {};
    },
    filterProjects() {
      let result = this.projects;
      if (this.selectedStatus) {
        result = result.filter((project) => project.status == this.selectedStatus);
      }

      if (this.selectedCategory) {
        result = result.filter((project) => project.category.id == this.selectedCategory);
      }

      return result;
    }
  },
  created() {
    this.getCategories();
    this.getAllProjects();
  },
  methods: {
    ...mapActions({
      getAllProjects: 'project/getAllProjects',
      getCategories: 'category/getAllCategories'
    }),
    openTask(task) {
      this.open = true;
      this.selectedProject = task;
      document.body.style.overflowY = 'hidden';
    },
    closeTaskModal(e) {
      this.open = false;
      this.selectedTask = null;
      document.body.style.overflowY = 'auto';
    },
    taskStatus(task) {
      switch (task.status) {
        case 1:
          return 'Open';
        case 2:
          return 'Assigned';
        case 3:
          return 'Completed';
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.list-gig {
  .container {
    @apply py-20 px-4 grid grid-cols-1 md:grid-cols-3 gap-8;
  }
  &__welcome {
    @apply p-6 bg-white border border-gray-200 rounded-md space-y-4;
  }

  &__content {
    @apply bg-white border border-gray-200 rounded-md;
  }
}
</style>
