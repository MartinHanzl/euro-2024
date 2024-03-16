<template>
  <div class="grid grid-cols-2 gap-12">
    <div class="shadow rounded">
      <div class="bg-slate-800 pl-4 md:pl-8 pt-2 md:pt-4 pb-2 md:pb-4 pr-4 md:pr-8 rounded-t">
        <h2 class="text-slate-200 font-bold">
          Vaše ligy
        </h2>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
} from '@headlessui/vue'

definePageMeta({
  middleware: 'auth'
})
</script>