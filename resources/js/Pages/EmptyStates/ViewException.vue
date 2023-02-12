<template>
  <!-- Use the layout component to define the page layout e.g. "AppLayout" -->
  <div class="w-full">
    <empty-state :width="'w-full'">
      <template #title>
        {{ __(title) }}
      </template>
      <template #description>
        {{ __(message) }}
      </template>
    </empty-state>
  </div>
</template>

<script setup>
import EmptyState from "@/Misc/EmptyState.vue";

defineProps({
  title: {
    type: String,
    required: true,
  },
  message: {
    type: String,
    required: true,
  },
})
</script>
