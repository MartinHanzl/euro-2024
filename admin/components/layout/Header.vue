<template>
  <header class="bg-white shadow rounded-lg">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-lg lg:text-3xl font-bold tracking-tight text-gray-900">
        {{ title }}
      </h1>
    </div>
  </header>
</template>

<script type="ts" setup>
defineProps({
  title: {
    type: String,
    default: ''
  }
})
</script>