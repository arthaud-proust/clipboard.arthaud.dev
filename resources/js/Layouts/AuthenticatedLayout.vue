<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import {Link, usePage} from "@inertiajs/vue3";
import {ChevronDownIcon} from "@heroicons/vue/16/solid";

const page = usePage()
</script>

<template>
    <div class="min-h-dvh">
        <nav class="flex h-12 justify-between px-2 text-neutral-500">
            <Link href="/" class="flex items-center px-3">
                Clipboard
            </Link>

            <Dropdown align="right" width="48" class="ml-auto">
                <template #trigger>
                    <div
                        class="h-full inline-flex items-center px-3 transition duration-150 ease-in-out hover:text-gray-700"
                    >
                        {{ page.props.auth.user.email }}

                        <ChevronDownIcon class="size-4" />
                    </div>
                </template>

                <template #content>
                    <DropdownLink
                        :href="route('profile.edit')"
                    >
                        Profile
                    </DropdownLink>
                    <DropdownLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        Log Out
                    </DropdownLink>
                </template>
            </Dropdown>
        </nav>

        <slot />
    </div>
</template>
