<script setup>
import {onMounted, reactive, ref} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';

// Only for testing locales
import {loadLanguageAsync, trans} from 'laravel-vue-i18n';
const locale = ref('en');

onMounted(() => locale.value = window.navigator.language.split('-')[0]);

const changeLocale = (lang) => {
  loadLanguageAsync(lang);
  locale.value = lang;
}

</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="flex justify-end space-x-2 items-center px-4 py-2">
            <button @click="changeLocale('en')" :class="{'active': locale === 'en'}">EN</button>
            <button @click="changeLocale('de')" :class="{'active': locale === 'de'}">DE</button>
          </div>
          <hr class="border border-gray-50">
          <div class="w-full p-4">
            {{ trans('Taylor Otwell is an American software engineer and entrepreneur, best known as the creator of the Laravel PHP framework. He has been involved in web development since the early 2000s and has been a significant contributor to the PHP community. In addition to Laravel, he has also created a number of other popular open-source projects and tools, including Forge, Envoyer, and Spark. Otwell is widely regarded as one of the leading figures in the PHP community, and he continues to be active in the development of Laravel and other projects.') }}
          </div>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <Welcome/>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style lang="scss" scoped>
button {
  @apply inline-block rounded-lg px-3 py-1.5 text-sm font-semibold leading-6 text-gray-900 shadow-sm ring-1 ring-gray-900/10 hover:ring-gray-900/20;
  &.active {
    @apply bg-gray-900/10;
  }
}
</style>
