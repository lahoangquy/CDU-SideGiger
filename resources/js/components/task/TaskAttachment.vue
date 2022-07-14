<template>
  <div
    class="attachment flex items-center gap-2 mt-4"
    v-if="project.attachments && project.attachments.length"
  >
    <a
      class="text-xs rounded-full bg-gray-200 py-1 px-2 flex items-center gap-1"
      :href="`/storage/uploads/${attachment.file_name}`"
      target="_blank"
      v-for="attachment in project.attachments"
      :key="attachment.id"
    >
      <svg-vue icon="link" class="w-3 h-3" />
      {{ attachment.file_name }}
    </a>
  </div>
</template>

<script>
export default {
  props: {
    project: {
      type: Object,
      required: true,
      default: () => {}
    }
  }
};
</script>
