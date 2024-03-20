<template>
  <div>
    <Header title="Základní skupina" />
    {{ formData.home_team_goals }}
    <ul
      v-if="games"
      role="list"
      class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
    >
      <li
        v-for="game in games.games"
        :key="game.id"
        class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow"
      >
        <div class="flex w-full items-center justify-between space-x-6 p-6">
          <div class="flex justify-between flex-1 truncate">
            <div class="flex items-center space-x-3">
              <p class="truncate w-full text-sm font-bold text-slate-900">
                {{ game.home_team.name }}
              </p>
              <p class="truncate text-sm font-bold text-slate-900">
                <input
                  id="home_team_goals"
                  v-model="formData.home_team_goals"
                  name="home_team_goald"
                  type="text"
                  required
                  class="block w-1/2 rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8 text-center"
                >
              </p>
            </div>
            <div class="flex items-center space-x-3">
              <p class="truncate text-sm font-bold text-slate-900">
                <input
                  id="away_team_goals"
                  name="away_team_goals"
                  type="text"
                  :value="game.tip.away_goals ?? '-'"
                  required
                  class="block w-1/2 rounded-md border-0 py-1.5 text-slate-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-8 text-center"
                >
              </p>
              <p class="truncate w-full text-sm font-bold text-slate-900">
                {{ game.away_team.name }}
              </p>
            </div>
          </div>
        </div>
        <div class="flex w-full items-center justify-between space-x-6 p-6">
          <div class="flex justify-between flex-1 truncate">
            <div class="flex items-center space-x-3">
              <p class="truncate w-full text-sm font-bold text-slate-900">
                {{ game.home_team.name }}
              </p>
            </div>
            <div class="flex items-center space-x-3">
              <p class="truncate w-full text-sm font-bold text-slate-900">
                {{ game.away_team.name }}
              </p>
            </div>
          </div>
        </div>
        <div>
          <div class="-mt-px flex divide-x divide-gray-200">
            <div class="flex w-0 flex-1">
              <a
                href="howpossible17@example.com"
                class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-slate-900"
              >
                Email
              </a>
            </div>
            <div class="-ml-px flex w-0 flex-1">
              <a
                href="tel:+1-202-555-0170"
                class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-slate-900"
              >
                Call
              </a>
            </div>
          </div>
        </div>
      </li>
    </ul>
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
      const [games] = await Promise.all([
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
      return {games};
    }
);

const formData = ref({
  home_team_goals: 0,
  away_team_goals: 0,
  booster: false
})
</script>