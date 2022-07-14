<template>
  <div class="py-8 px-6">
    <h3 class="text-lg font-medium mb-6">Activity on this task</h3>
    <ul>
      <li>
        <span class="text-gray-500 text-sm">Proposals:</span>
        <span>{{ project.offers.length }}</span>
      </li>
      <li>
        <span class="text-gray-500 text-sm">Last viewed by client:</span>
        <span>4 minutes ago</span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    project: {
      type: Object,
      required: true,
      default: {}
    }
  }
};
</script>
