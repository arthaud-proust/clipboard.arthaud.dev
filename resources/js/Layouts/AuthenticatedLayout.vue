<script setup lang="ts">
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { ChevronDownIcon } from '@heroicons/vue/16/solid';
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

const page = usePage();

const { t } = useI18n();
</script>

<template>
    <div class="min-h-dvh">
        <nav class="flex h-12 justify-between px-2 text-neutral-500">
            <Link href="/" class="flex items-center px-3">
                {{ t('clipboard') }}
            </Link>

            <Dropdown align="right" width="48" class="ml-auto">
                <template #trigger>
                    <div
                        class="inline-flex h-full items-center px-3 transition duration-150 ease-in-out hover:text-gray-700"
                    >
                        {{ page.props.auth.user.email }}

                        <ChevronDownIcon class="size-4" />
                    </div>
                </template>

                <template #content>
                    <DropdownLink :href="route('profile.edit')">
                        {{ t('profile') }}
                    </DropdownLink>
                    <DropdownLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        {{ t('log_out') }}
                    </DropdownLink>
                </template>
            </Dropdown>
        </nav>

        <slot />
    </div>
</template>
