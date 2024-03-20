<template>
  <header class="bg-white shadow rounded-lg">
    <div class="flex items-center justify-between mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="flex-1 text-lg lg:text-3xl font-bold tracking-tight text-slate-900">
        {{ title }}
      </h1>
      <div class="flex-0">
        <button
          v-if="functionTitle !== ''"
          class="flex-1 text-sm text-green-600 bg-green-100 rounded-lg py-2 px-4 font-bold hover:bg-green-200 ring-1 ring-green-300"
          @click="clicked"
        >
          {{ functionTitle }}
        </button>
      </div>
    </div>
  </header>
</template>

<script type="ts" setup>
defineProps({
  title: {
    type: String,
    default: ''
  },
  functionTitle: {
    type: String,
    default: ''
  }
})

const emits = defineEmits(['openModal']);
const clicked = () => emits('openModal');
</script>