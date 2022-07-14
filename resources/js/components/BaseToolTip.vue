<template>
  <div
    :id="toolTipId"
    role="tooltip"
    class="
      inline-block
      absolute
      invisible
      z-10
      py-2
      px-3
      text-sm
      font-medium
      text-gray-900
      bg-white
      rounded-lg
      border border-gray-200
      shadow-sm
      opacity-0
      tooltip
    "
  >
    {{ content }}
    <div class="tooltip-arrow" data-popper-arrow></div>
  </div>
</template>

<script>
export default {
  props: ['toolTipId', 'content']
};
</script>

<style></style>
