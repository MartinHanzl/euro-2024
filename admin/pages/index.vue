<template>
  <div>
    <div class="pb-8 mb-8 border-b-2 border-darkBlue">
      <h1 class="w-full text-4xl font-bold">
        Nástěnka
      </h1>
    </div>
    <div class="grid grid-cols-2 gap-12">
      {{ games }}
    </div>
  </div>
</template>

<script lang="ts" setup>
import {useAsyncData} from "#app";

definePageMeta({
  middleware: 'auth'
})
const apiBase = useRuntimeConfig().public.apiBase;
const token = useCookie('token').value;

const {data: games, pending, error, refresh} = useAsyncData(
    'games',
    async () => {
      const [users] = await Promise.all([
        $fetch(`${apiBase}/api/games`, {
          method: 'GET',
          params: {
            type: 'group'
          },
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
          },
        })
      ])
      return {users};
    }
);
</script>