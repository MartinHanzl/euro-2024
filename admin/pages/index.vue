<template>
  <div>
    <div class="pb-8 mb-8 border-b-2 border-darkBlue">
      <h1 class="w-full text-4xl font-bold">
        Nástěnka
      </h1>
    </div>
    <div class="grid grid-cols-2 gap-12">
      <div class="shadow rounded">
        <div class="bg-darkBlue pl-4 md:pl-8 pt-2 md:pt-4 pb-2 md:pb-4 pr-4 md:pr-8 rounded-t">
          <h2 class="text-slate-200 font-bold">
            Vaše ligy
          </h2>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>

definePageMeta({
  middleware: 'auth'
})
</script>