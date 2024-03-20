<template>
  <div>
    <Header
      title="Zápasy"
      function-title="Přidat zápas"
      function="openModal"
      @open-modal="openModal"
    >
      {{ isModalOpen }}
      <div>
        {{ games }}
      </div>
      <template>
        <TransitionRoot
          v-model="inlineData.isModalOpen"
          as="template"
        >
          <Dialog
            as="div"
            class="relative z-10"
            @close="inlineData.isModalOpen = false"
          >
            <TransitionChild
              as="template"
              enter="ease-out duration-300"
              enter-from="opacity-0"
              enter-to="opacity-100"
              leave="ease-in duration-200"
              leave-from="opacity-100"
              leave-to="opacity-0"
            >
              <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
              <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <TransitionChild
                  as="template"
                  enter="ease-out duration-300"
                  enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                  enter-to="opacity-100 translate-y-0 sm:scale-100"
                  leave="ease-in duration-200"
                  leave-from="opacity-100 translate-y-0 sm:scale-100"
                  leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                  <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                      <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                          <CalendarDaysIcon
                            class="h-6 w-6 text-green-600"
                            aria-hidden="true"
                          />
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                          <DialogTitle
                            as="h3"
                            class="text-base font-semibold leading-6 text-gray-900"
                          >
                            Přidat zápas
                          </DialogTitle>
                          <div class="mt-2 w-full">
                            <div class="grid grid-cols-2 w-full">
                              <div>Ahoj</div>
                              <div>Ahoj</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                      <button
                        type="button"
                        class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto"
                        @click="inlineData.isModalOpen = false"
                      >
                        Přidat
                      </button>
                      <button
                        ref="cancelButtonRef"
                        type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                        @click="inlineData.isModalOpen = false"
                      >
                        Zrušit
                      </button>
                    </div>
                  </DialogPanel>
                </TransitionChild>
              </div>
            </div>
          </Dialog>
        </TransitionRoot>
      </template>
    </header>
  </div>
</template>

<script lang="ts" setup>
import {useAsyncData, useState} from "#app";
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { CalendarDaysIcon } from '@heroicons/vue/24/outline'

definePageMeta({
  middleware: 'auth'
})
const apiBase = useRuntimeConfig().public.apiBase;
const token = useCookie('token').value;

const {data: games, pending, error, refresh} = useAsyncData(
    'games',
    async () => {
      const [games] = await Promise.all([
        $fetch(`${apiBase}/api/games`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        })
      ])
      return {games};
    }
);
const inlineData = ref({
  isModalOpen: false
});
function openModal() {
  inlineData.isModalOpen = true;
  console.log(inlineData.isModalOpen)
}
</script>