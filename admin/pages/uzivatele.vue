<template>
  <div>
    <div class="pb-8 mb-8 border-b-2 border-darkBlue">
      <h1 class="w-full text-4xl">
        Uživatelé
      </h1>
    </div>
  </div>
</template>

<script lang="ts" setup>

definePageMeta({
  middleware: 'auth'
})
</script>