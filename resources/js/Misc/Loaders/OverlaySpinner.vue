<template>
  <div
      :class="{'absolute': !fixed, 'fixed': fixed}"
      :style="style"
      class="top-0 left-0 flex items-center justify-center w-full h-full rounded flex-col z-40">

    <div :class="{'m-20': size === 'large', 'm-6': size === 'small'}" class="flex justify-center items-center">
      <div class="spinner" :class="{'w-8 h-8 border': size === 'small', 'w-16 h-16 border-4': size === 'large'}"/>
    </div>

  </div>
</template>

<script>
export default {
  name: "OverlaySpinner",
  props: {
    fixed: {},
    size: {
      default: 'large'
    },
    backgroundOpacity: {}
  },
  computed: {
    style() {
      return {
        background: `rgba(0, 0, 0, ${this.backgroundOpacity || 0.45})`
      }
    }
  }
}
</script>

<style scoped lang="scss">
.spinner {
  border-radius: 50%;
  animation: spin 1s cubic-bezier(0.55, 0.25, 0.25, 0.70) infinite;
  border-color: rgb(255, 255, 255) rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.2);
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>