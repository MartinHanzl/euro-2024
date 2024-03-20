<template>
  <div>
    <div class="pb-8 mb-8 border-b-2 border-darkBlue">
      <h1 class="w-full text-4xl font-bold">
        Uživatelé
      </h1>
    </div>
    <div>
      <table
        v-if="users"
        class="w-full rounded-2xl border-collapse bg-white text-left text-sm text-slate-500"
      >
        <thead class="bg-slate-50">
          <tr>
            <th
              scope="col"
              class="px-6 py-4 font-bold text-slate-900"
            >
              ID
            </th>
            <th
              scope="col"
              class="px-6 py-4 font-bold text-slate-900"
            >
              Jméno a příjmení
            </th>
            <th
              scope="col"
              class="px-6 py-4 font-bold text-slate-900"
            >
              Email
            </th>
            <th
              scope="col"
              class="px-6 py-4 font-bold text-slate-900"
            >
              Stav
            </th>
            <th
              scope="col"
              class="px-6 py-4 font-bold text-slate-900"
            >
              Akce
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 border-t border-slate-100">
          <tr
            v-for="user in users.users"
            :key="user.id"
            class="hover:bg-slate-50"
          >
            <td class="px-6 py-4">
              {{ user.id }}
            </td>
            <td class="px-6 py-4">
              {{ user.firstname + ' ' + user.lastname }}
            </td>
            <td class="px-6 py-4">
              {{ user.email }}
            </td>
            <td class="px-6 py-4">
              <span
                v-if="user.verified"
                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600"
              >
                Ověřený
              </span>
              <span
                v-else
                class="inline-flex items-center gap-1 rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-500"
              >
                Čeká na schválení
              </span>
            </td>
            <td class="px-6 py-4" />
          </tr>
        </tbody>
      </table>
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