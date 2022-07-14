<template>
  <div class="group task-item" @click.stop.prevent="$emit('open-task', project)">
    <h3>
      <a :href="`/project/${project.id}/${project.slug}`">{{
        project.title
      }}</a>
    </h3>
    <TaskPostInfo :project="project" />
    <div class="text-gray-600/80 text-sm" v-html="project.description"></div>

    <TaskAttachment :project="project" />
  </div>
</template>

<script>
import TaskAttachment from './TaskAttachment.vue';
import TaskPostInfo from './TaskPostInfo.vue';
export default {
  components: { TaskPostInfo, TaskAttachment },
  props: {
    project: {
      type: Object,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
.task-item {
  @apply cursor-pointer flex flex-col bg-white hover:bg-gray-50 transition duration-300 p-6 border-b border-gray-200;

  h3 {
    @apply font-medium group-hover:text-red-700 text-xl;
  }

  &__post-info {
    @apply flex flex-1 justify-between space-x-4 mt-2 mb-4;
  }

  .tag {
    @apply text-gray-500 px-3 py-1 bg-gray-100 rounded-full hover:bg-gray-200 transition duration-300;
  }
}
</style>
