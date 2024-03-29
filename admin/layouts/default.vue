<template>
  <div class="min-h-full">
    <Disclosure
      v-slot="{ open }"
      as="nav"
      class="bg-slate-200 shadow-2xl"
    >
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <img
                class="h-8 w-8"
                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                alt="Your Company"
              >
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                <nuxt-link
                  v-for="item in navigation"
                  :key="item.name"
                  :to="item.href"
                  :class="[item.current ? 'border-2 border-darkBlue text-darkBlue' : 'text-darkBlue hover:bg-darkBlue hover:text-white', 'rounded-full px-4 py-2 text-sm font-bold']"
                  :aria-current="item.current ? 'page' : undefined"
                >
                  {{ item.name }}
                </nuxt-link>
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <!-- Profile dropdown -->
              <Menu
                as="div"
                class="relative ml-3"
              >
                <div>
                  <MenuButton class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                    <span class="absolute -inset-1.5" />
                    <span class="sr-only">Open user menu</span>
                    <img
                      class="h-8 w-8 rounded-full"
                      :src="todo"
                      alt=""
                    >
                  </MenuButton>
                </div>
                <transition
                  enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100"
                  leave-to-class="transform opacity-0 scale-95"
                >
                  <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem
                      v-for="item in userNavigation"
                      :key="item.name"
                      v-slot="{ active }"
                    >
                      <nuxt-link
                        :to="item.href"
                        :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']"
                      >
                        {{ item.name }}
                      </nuxt-link>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
              <span class="absolute -inset-0.5" />
              <span class="sr-only">Open main menu</span>
              <Bars3Icon
                v-if="!open"
                class="block h-6 w-6"
                aria-hidden="true"
              />
              <XMarkIcon
                v-else
                class="block h-6 w-6"
                aria-hidden="true"
              />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
          <DisclosureButton
            v-for="item in navigation"
            :key="item.name"
            as="a"
            :href="item.href"
            :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
            :aria-current="item.current ? 'page' : undefined"
          >
            {{ item.name }}
          </DisclosureButton>
        </div>
        <div class="border-t border-gray-700 pb-3 pt-4">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <img
                class="h-10 w-10 rounded-full"
                :src="todo"
                alt=""
              >
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">
                {{ authUser.firstname + ' ' + authUser.lastname }}
              </div>
              <div class="text-sm font-medium leading-none text-gray-400">
                {{ authUser.email }}
              </div>
            </div>
          </div>
          <div class="mt-3 space-y-1 px-2">
            <DisclosureButton
              v-for="item in userNavigation"
              :key="item.name"
              as="a"
              :href="item.href"
              class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white"
            >
              {{ item.name }}
            </DisclosureButton>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>
    <main>
      <div class="mx-4 lg:mx-auto max-w-7xl py-12 sm:px-6 lg:px-8">
        <p @click="logout">
          Logout
        </p>
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/store/auth';

useHead({
  bodyAttrs: {
    class: 'h-full'
  },
  htmlAttrs: {
    class: 'h-full'
  }
});
const router = useRouter();

const { logUserOut } = useAuthStore();
const { authUser } = storeToRefs(useAuthStore());

const logout = () => {
  logUserOut();
  router.push('/login');
};

const navigation = [
  { name: 'Nástěnka', href: '/', current: true },
  { name: 'Základní skupina', href: '/zakladni-skupina', current: false },
  { name: 'Vyřazovací část', href: '/vyrazovaci-cast', current: false },
  { name: 'Ligy', href: '/ligy', current: false }
]

if (authUser.value.role === 'admin' || authUser.value.role === 'employee') {
  navigation.push({name: 'Zápasy', href: '/zapasy', current: false});
}

if (authUser.value.role === 'admin') {
  navigation.push({name: 'Uživatelé', href: '/uzivatele', current: false});
}

const userNavigation = [
  { name: 'Profil', href: '#' },
  { name: 'Odhlásit se', href: '#' },
]
</script>
