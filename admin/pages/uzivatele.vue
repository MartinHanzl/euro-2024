<template>
  <div>
    <div class="pb-8 mb-8 border-b-2 border-darkBlue">
      <h1 class="w-full text-4xl font-bold">
        Uživatelé
      </h1>
    </div>
    <p v-if="pending">
      Loading
    </p>
    <p
      v-for="user in users.users"
      v-else
      :key="user.id"
    >
      {{ user.email }}
    </p>
  </div>
</template>

<script lang="ts" setup>
import {useAsyncData} from "#app";

definePageMeta({
  middleware: 'auth'
})
const apiBase = useRuntimeConfig().public.apiBase;
const token = useCookie('token').value;

const {data: users, pending, error, refresh} = useAsyncData(
    'users',
    async () => {
      const [users] = await Promise.all([
        $fetch(`${apiBase}/api/users`, {
          method: 'GET',
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