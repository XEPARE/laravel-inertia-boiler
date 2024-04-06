<script setup>
import EmptyState from "@/Casual/EmptyState.vue";
import {trans} from "laravel-vue-i18n";

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

<template>
  <!-- Use the layout component to define the page layout e.g. "AppLayout" -->
  <div class="w-full md:p-48 bg-gray-100 h-screen">
    <empty-state :width="'w-full'">
      <template #title>
        {{ trans(title) }}
      </template>
      <template #description>
        {{ trans(message) }}
      </template>
    </empty-state>
  </div>
</template>
