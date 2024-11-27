<script setup lang="ts">
import { usePoll } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';

defineProps<{
    token: string;
}>();

const { t } = useI18n();

usePoll(2000);
</script>
<template>
    <div
        class="mx-auto flex min-h-dvh max-w-lg flex-col justify-center gap-8 px-2 py-8 text-lg"
    >
        <div>
            <p class="text-neutral-500">{{ t('device_b') }}</p>
            <h1 class="text-5xl">{{ t('token', { token }) }}</h1>
            <p>{{ t('waiting_for_approval_on_devicea') }}</p>
        </div>
    </div>
</template>
