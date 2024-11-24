<script setup lang="ts">
import { usePoll } from '@inertiajs/vue3';

defineProps<{
    token: string;
}>();

usePoll(2000);
</script>
<template>
    <div
        class="mx-auto flex min-h-dvh max-w-lg flex-col justify-center gap-8 px-2 py-8 text-lg"
    >
        <div>
            <p class="text-neutral-500">Device B</p>
            <h1 class="text-5xl">Token {{ token }}</h1>
            <p>Waiting for approval on device A...</p>
        </div>
    </div>
</template>
